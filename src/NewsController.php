<?php

class NewsController
{
    public function __construct(private NewsGateway $gateway)
    {
    }

    public function processRequest(string $method, ?string $news_id): void
    {
        if ($news_id) {

            $this->processResourceRequest($method, $news_id);

        } else {

            $this->processCollectionRequest($method);

        }
    }

    private function processResourceRequest(string $method, string $id): void
    {
        $news = $this->gateway->get($id);

        if ( ! $news) {
            http_response_code(404);
            echo json_encode(["message" => "Site not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($news);
                break;

            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data, false);

                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->gateway->update($news, $data);

                echo json_encode([
                    "message" => "News $id updated",
                    "rows" => $rows
                ]);
                break;

            case "DELETE":
                $rows = $this->gateway->delete($id);

                echo json_encode([
                    "message" => "News $id deleted",
                    "rows" => $rows
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }
    }

    private function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case "GET":
                echo json_encode($this->gateway->getAll());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if ( ! empty($errors)) {
                  break;
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                }

                $id = $this->gateway->create($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "Site created",
                    "id" => $id
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];

        if ($is_new && empty($data["news_id"])) {
            $errors[] = "news_id is required";
        }

        if (array_key_exists("size", $data)) {
            if (filter_var($data["size"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "size must be an integer";
            }
        }

        return $errors;
    }
}
