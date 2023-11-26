<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Selective\BasePath\BasePathMiddleware;

$app = AppFactory::create();
$app->get('/blog/all', function (Request $request, Response $response) {
    $sql = "SELECT * FROM blog";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $blog = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $response->getBody()->write(json_encode($blog));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus (200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write (json_encode ($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus (500);
    }
});

$app->get('/blog/{id}', function (Request $request, Response $response, array $args) {
    $id = $args ['id'];
    $sql = "SELECT * FROM blog WHERE blog_id = $id";
    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $blog = $stmt->fetch (PDO::FETCH_OBJ);
        $db = null;
        $response->getBody ()->write(json_encode( $blog) );
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus (200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody ()->write(json_encode( $error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus (500);
    }
});

$app->delete('/blog/delete/{id}', function (Request $request, Response $response, array $args) {
    $id = $args ['id'];
    $sql = "DELETE FROM blog WHERE blog_id = $id";

    try{
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    }catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus (500);
    }
});

$app->patch(
    '/blog/update/{id}',
    function (Request $request, Response $response, array $args) {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $blog_id = $data["blog_id"];
        $nickname = $data["nickname"];
        $text = $data["text"];
        $date = $data["date"];

        $sql = "UPDATE blog SET blog_id = :blog_id, nickname = :nickname, text = :text, date = :date WHERE id = $id";


        try {
            $db = new Db();
            $conn = $db->connect();

            $stmt = $conn->prepare($sql);
            $stmt->bindParams(':blog_id', $blog_id);
            $stmt->bindParams(':nickname', $nickname);
            $stmt->bindParams(':text', $text);
            $stmt->bindParams(':date', $date);

            $result = $stmt->execute();

            $db = null;
            echo "Update successful! ";
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
);






$app->post('/blog/add', function (Request $request, Response $response, array $args) {
    $data = $request->getParsedBody();

    if (isset($data["email"], $data["display_name"], $data["phone"])) {
        $blog_id = $data["blog_id"];
        $nickname = $data["nickname"];
        $text = $data["text"];
        $date = $data["date"];

        $sql = "INSERT INTO blog (blog_id, nickname, text, date) VALUES (:blog_id, :nickname, :text, :date)";

        try {
            $db = new Db();
            $conn = $db->connect();

            $stmt = $conn->prepare($sql);
            $stmt->bindParams(':blog_id', $blog_id);
            $stmt->bindParams(':nickname', $nickname);
            $stmt->bindParams(':text', $text);
            $stmt->bindParams(':date', $date);

            $result = $stmt->execute();

            $db = null;
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    } else {
        $error = array(
            "message" => "One or more required keys are missing in the request body."
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(400); // Bad Request
    }
});

