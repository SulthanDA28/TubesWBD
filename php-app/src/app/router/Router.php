<?php

require_once SRC_ROOT_PATH . "/app/exceptions/BadRequestException.php";
require_once SRC_ROOT_PATH . "/app/exceptions/MethodNotAllowedException.php";

class Router {
  private $pathAndHandler;

  public function addHandler($path, $handler, $middlewares) {
    $this->pathAndHandler[$path] = [$handler, $middlewares];
  }

  public function run($path, $method) {
    try {
      $pathWithoutQuery = explode('?', $path)[0];
      $this->routing($pathWithoutQuery, $method);
    } catch (BadRequestException $e) {
      header("HTTP/1.0 400 Bad Request");
  
    } catch (MethodNotAllowedException $e) {
      header("HTTP/1.0 405 Method Not Allowed");
      
    } catch (Exception $e) {
      header("HTTP/1.0 500 Internal Server Error");
    }
  }

  private function routing($path, $method) {
    foreach ($this->pathAndHandler as $key => $value) {
      $match = $this->isMatch($path, $key);
      if ($match[0]) {
        $middlewares = $value[1];

        $isPass = true;
        foreach ($middlewares as $middleware) {
          $isPass = $middleware($path, $method);
          if (!$isPass) {
            break;
          }
        }
      
        if ($isPass) {
          echo $value[0]->handle($method, $match[1]);
          exit();
        }
        else {
          header("Location: /");
          exit();
        }
      }
    }
    header("Location: /");
    throw new MethodNotAllowedException("Method not allowed");
  }

  public function isMatch($path, $keyHandler) {
    $path = explode("/", $path);
    $keyHandler = explode("/", $keyHandler);

    if (count($path) !== count($keyHandler)) {
      return [false, []];
    }

    $urlParams = [];

    for ($i = 0; $i < count($path); $i++) {
      if ($path[$i] !== $keyHandler[$i] && $keyHandler[$i] !== "*") {
        return [false, []];
      }

      if ($keyHandler[$i] === "*") {
        $urlParams[] = $path[$i];
      }
    }

    return [true, $urlParams];
  }
}

