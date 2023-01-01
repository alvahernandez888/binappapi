<?php

class ContractController
{
    public function __construct(private ContractGateway $gateway)
    {
    }

    public function processRequest(string $method, ?string $contract): void
    {
        if ($contract) {

            $this->processResourceRequest($method, $contract);

        } else {

            $this->processCollectionRequest($method);

        }
    }

    private function processResourceRequest(string $method, string $id): void
    {
        $contract = $this->gateway->get($id);

        if ( ! $contract) {
            http_response_code(404);
            echo json_encode(["message" => "Site not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($contract);
                break;

            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data, false);

                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->gateway->update($contract, $data);

                echo json_encode([
                    "message" => "Contract $id updated",
                    "rows" => $rows
                ]);
                break;

            case "DELETE":
                $rows = $this->gateway->delete($id);

                echo json_encode([
                    "message" => "Contract $id deleted",
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

        if ($is_new && empty($data["contract"])) {
            $errors[] = "contract is required";
        }

        if (array_key_exists("size", $data)) {
            if (filter_var($data["size"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "size must be an integer";
            }
        }

        return $errors;
    }
}
