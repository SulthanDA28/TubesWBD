CREATE TABLE "users" (
  "id" SERIAL PRIMARY KEY,
  "username" varchar UNIQUE NOT NULL,
  "profile_name" varchar NOT NULL,
  "password_hashed" varchar NOT NULL,
  "role" varchar NOT NULL,
  "status" varchar DEFAULT null,
  "profile_picture_path" varchar,
  "created_at" timestamp DEFAULT current_timestamp,

  CONSTRAINT username_length CHECK (char_length(username) <= 30),
  CONSTRAINT profile_name_length CHECK (char_length(profile_name) <= 30),
  CONSTRAINT check_username CHECK (username <> ''),
	CONSTRAINT check_profile_name CHECK (profile_name <> '')
);

CREATE TABLE "users_detail" (
  "id" integer PRIMARY KEY,
  "banner_path" varchar,
  "bio" text,
  "birth_date" date,
  "location" varchar
);

CREATE TABLE "user_roles" (
  "role" varchar PRIMARY KEY
);

CREATE TABLE "follows" (
  "following_user_id" integer NOT NULL,
  "followed_user_id" integer NOT NULL,
  "created_at" timestamp DEFAULT current_timestamp,

  CONSTRAINT no_self_follow CHECK (following_user_id <> followed_user_id)
);

CREATE TABLE "posts" (
  "post_id" integer,
  "owner_id" integer,
  "body" text,
  "created_at" timestamp DEFAULT current_timestamp,
  "refer_type" varchar DEFAULT null,
  "refer_post" integer DEFAULT null,
  "refer_post_owner" integer DEFAULT null,
  "tags" varchar[] DEFAULT '{}',
  "likes" integer DEFAULT 0,
  "shares" integer DEFAULT 0,
  "views" integer DEFAULT 0,
  PRIMARY KEY ("post_id", "owner_id"),

  CONSTRAINT no_self_refer CHECK (refer_post <> post_id AND refer_post_owner <> owner_id)
);
-- CURRENT IMPLEMENTATION ONLY ACCEPTS "refer_type" values of {'Repost', 'Reply'}

CREATE TABLE "post_resources" (
  "post_id" integer,
  "post_owner_id" integer,
  "path" varchar
);

CREATE TABLE "likes" (
  "post_id" integer,
  "post_owner_id" integer,
  "user_id" integer,
  "created_at" timestamp DEFAULT current_timestamp
);

COMMENT ON COLUMN "users"."id" IS 'Starts at 1';

COMMENT ON COLUMN "users"."status" IS 'null status represents normal user';

COMMENT ON COLUMN "posts"."post_id" IS 'Starts at 0';

COMMENT ON COLUMN "posts"."body" IS 'Content of the post';

COMMENT ON COLUMN "posts"."refer_type" IS 'Refer type, e.g. Repost(Retweet), Reply';

COMMENT ON COLUMN "post_resources"."path" IS 'Path to the resource in filesystem';

COMMENT ON COLUMN "likes"."user_id" IS 'The user which likes the post';

ALTER TABLE "users" ADD FOREIGN KEY ("role") REFERENCES "user_roles" ("role");

ALTER TABLE "users_detail" ADD FOREIGN KEY ("id") REFERENCES "users" ("id");

ALTER TABLE "follows" ADD FOREIGN KEY ("following_user_id") REFERENCES "users" ("id");

ALTER TABLE "follows" ADD FOREIGN KEY ("followed_user_id") REFERENCES "users" ("id");

ALTER TABLE "posts" ADD FOREIGN KEY ("owner_id") REFERENCES "users" ("id");

ALTER TABLE "posts" ADD FOREIGN KEY ("refer_post", "refer_post_owner") REFERENCES "posts" ("post_id", "owner_id");

ALTER TABLE "post_resources" ADD FOREIGN KEY ("post_id", "post_owner_id") REFERENCES "posts" ("post_id", "owner_id");

ALTER TABLE "likes" ADD FOREIGN KEY ("post_id", "post_owner_id") REFERENCES "posts" ("post_id", "owner_id");

CREATE INDEX user_post ON posts USING HASH(owner_id);

CREATE FUNCTION add_user_detail() RETURNS TRIGGER AS $$
  BEGIN
    INSERT INTO users_detail(id) VALUES(NEW.id);
    RETURN NEW;
  END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER add_user_detail
  AFTER INSERT ON users
  FOR EACH ROW
  EXECUTE FUNCTION add_user_detail();

-- CREATE FUNCTION validate_role() RETURNS TRIGGER AS $$
--   BEGIN
--     IF (NEW.role NOT IN (SELECT role FROM user_roles)) THEN
--       RAISE NOTICE 'Role not found!';
--       RETURN NULL;
--     END IF;
--     RETURN NEW;
--   END;
-- $$ LANGUAGE plpgsql;

-- CREATE TRIGGER validate_role
--   BEFORE INSERT OR UPDATE ON users
--   EXECUTE FUNCTION validate_role();

CREATE FUNCTION next_post_id(user_id int) RETURNS INTEGER AS $$
  BEGIN
    RETURN (
      SELECT COALESCE((MAX(post_id) + 1), 0)
      FROM posts
      WHERE owner_id = user_id
    );
  END;
$$ LANGUAGE plpgsql;

CREATE FUNCTION increment_post_id() RETURNS TRIGGER AS $$
  BEGIN
    NEW.post_id := next_post_id(NEW.owner_id);
    RETURN NEW;
  END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER increment_post_id
  BEFORE INSERT ON posts
  FOR EACH ROW
  EXECUTE FUNCTION increment_post_id();

CREATE FUNCTION validate_post_reference() RETURNS TRIGGER AS $$
  BEGIN
    IF (NEW.refer_type IS NOT NULL) THEN
      IF (NEW.refer_post IS NULL OR NEW.refer_post_owner IS NULL) THEN
        RAISE NOTICE 'Reference must not be NULL if refer_type is not NULL';
        RETURN NULL;
      END IF;
    END IF;
    RETURN NEW;
  END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER validate_post_reference
  BEFORE INSERT OR UPDATE ON posts
  FOR EACH ROW
  EXECUTE FUNCTION validate_post_reference();

CREATE FUNCTION increment_like() RETURNS TRIGGER AS $$
  BEGIN
    UPDATE posts
    SET likes = likes + 1
    WHERE owner_id = NEW.post_owner_id AND post_id = NEW.post_id;
    RETURN NEW;
  END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER increment_like
  AFTER INSERT ON likes
  FOR EACH ROW
  EXECUTE FUNCTION increment_like();

-- add basic roles
INSERT INTO user_roles(role) VALUES('admin');
INSERT INTO user_roles(role) VALUES('moderator');
INSERT INTO user_roles(role) VALUES('user');
