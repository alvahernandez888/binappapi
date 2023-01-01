<?php

class SiteGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT *
                FROM sites";

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }


    public function create(array $data): string
    {
        $sql = "INSERT INTO site (site_id, category, rawAddress, postalAddress, zone, contract)
                        VALUES (:site_id, :category, :rawAddress, :postalAddress, :zone, :contract)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":site_id", $data["site_id"], PDO::PARAM_STR);
        $stmt->bindValue(":category", $data["category"], PDO::PARAM_STR);
        $stmt->bindValue(":rawAddress", $data["rawAddress"], PDO::PARAM_STR);
        $stmt->bindValue(":postalAddress", $data["postalAddress"], PDO::PARAM_STR);
        $stmt->bindValue(":zone", $data["zone"], PDO::PARAM_STR);
        $stmt->bindValue(":contract", $data["contract"], PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $site_id): array
    {
        $sql = "SELECT *
                FROM sites
                WHERE site_id = :site_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":site_id", $site_id, PDO::PARAM_STR);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function update(array $current, array $new): int
    {
        $sql = "UPDATE sites
                SET category = :category, rawAddress = :rawAddress, postalAddress = :postalAddress, zone = :zone, contract = :contract
                WHERE site_id = :site_id";


        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":category", $new["category"] ?? $current["category"], PDO::PARAM_STR);
        $stmt->bindValue(":rawAddress", $new["rawAddress"] ?? $current["rawAddress"], PDO::PARAM_STR);
        $stmt->bindValue(":postalAddress", $new["postalAddress"] ?? $current["postalAddress"], PDO::PARAM_STR);
        $stmt->bindValue(":zone", $new["zone"] ?? $current["zone"], PDO::PARAM_STR);
        $stmt->bindValue(":contract", $new["contract"] ?? $current["contract"], PDO::PARAM_STR);

        $stmt->bindValue(":site_id", $current["site_id"], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $site_id): int
    {
        $sql = "DELETE FROM sites
                WHERE site_id = :site_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":site_id", $id, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
