FROM node:21-alpine

# set working directory
WORKDIR /app

# add app
COPY . ./

# install app dependencies
RUN npm install
RUN npm run build


# start app
EXPOSE 3000
CMD ["npm", "run", "docker"]
