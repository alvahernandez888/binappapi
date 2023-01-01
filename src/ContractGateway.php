<?php

class ContractGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT *
                FROM contracts";

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }


    public function create(array $data): string
    {
        $sql = "INSERT INTO contracts (contract, logoURL, primaryColor, secondaryColor, fbLink, twitterLink, igLink, websiteLink, soloSupportEmailAddress, councilSupportEmailAddress, whatGoesInBinURL, greenBinServiceName, greenBinAllowed, greenBinNotAllowed, greenBinIconURL, redBinServiceName, redBinAllowed, redBinNotAllowed, redBinIconURL, yellowBinServiceName, yellowBinAllowed, yellowBinNotAllowed, yellowBinIconURL, bringOutAfter, bringOutBefore)
                        VALUES (:contract, :logoURL, :primaryColor, :secondaryColor, :fbLink, :twitterLink, :igLink, :websiteLink, :soloSupportEmailAddress, :councilSupportEmailAddress, :whatGoesInBinURL, :greenBinServiceName, :greenBinAllowed, :greenBinNotAllowed, :greenBinIconURL, :redBinServiceName, :redBinAllowed, :redBinNotAllowed, :redBinIconURL, :yellowBinServiceName, :yellowBinAllowed, :yellowBinNotAllowed, :yellowBinIconURL, :bringOutAfter, :bringOutBefore)";


        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":contract", $data["contract"], PDO::PARAM_STR);
        $stmt->bindValue(":logoURL", $data["logoURL"], PDO::PARAM_STR);
        $stmt->bindValue(":primaryColor", $data["primaryColor"], PDO::PARAM_STR);
        $stmt->bindValue(":secondaryColor", $data["secondaryColor"], PDO::PARAM_STR);
        $stmt->bindValue(":fbLink", $data["fbLink"], PDO::PARAM_STR);
        $stmt->bindValue(":twitterLink", $data["twitterLink"], PDO::PARAM_STR);
        $stmt->bindValue(":igLink", $data["igLink"], PDO::PARAM_STR);
        $stmt->bindValue(":websiteLink", $data["websiteLink"], PDO::PARAM_STR);
        $stmt->bindValue(":soloSupportEmailAddress", $data["soloSupportEmailAddress"], PDO::PARAM_STR);
        $stmt->bindValue(":councilSupportEmailAddress", $data["councilSupportEmailAddress"], PDO::PARAM_STR);
        $stmt->bindValue(":whatGoesInBinURL", $data["whatGoesInBinURL"], PDO::PARAM_STR);
        $stmt->bindValue(":greenBinServiceName", $data["greenBinServiceName"], PDO::PARAM_STR);
        $stmt->bindValue(":greenBinAllowed", $data["greenBinAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":greenBinNotAllowed", $data["greenBinNotAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":greenBinIconURL", $data["greenBinIconURL"], PDO::PARAM_STR);
        $stmt->bindValue(":redBinServiceName", $data["redBinServiceName"], PDO::PARAM_STR);
        $stmt->bindValue(":redBinAllowed", $data["redBinAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":redBinNotAllowed", $data["redBinNotAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":redBinIconURL", $data["redBinIconURL"], PDO::PARAM_STR);
        $stmt->bindValue(":yellowBinServiceName", $data["yellowBinServiceName"], PDO::PARAM_STR);
        $stmt->bindValue(":yellowBinAllowed", $data["yellowBinAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":yellowBinNotAllowed", $data["yellowBinNotAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":yellowBinIconURL", $data["yellowBinIconURL"], PDO::PARAM_STR);
        $stmt->bindValue(":bringOutAfter", $data["bringOutAfter"], PDO::PARAM_STR);
        $stmt->bindValue(":bringOutBefore", $data["bringOutBefore"], PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $contract): array | false
    {
        $sql = "SELECT *
                FROM contracts
                WHERE contract = :contract";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":contract", $contract, PDO::PARAM_STR);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function update(array $current, array $new): int
    {
        $sql = "UPDATE contracts
                SET logoURL = :logoURL, primaryColor = :primaryColor, secondaryColor = :secondaryColor, fbLink = :fbLink, twitterLink = :twitterLink, igLink = :igLink, websiteLink = :websiteLink, soloSupportEmailAddress = :soloSupportEmailAddress, councilSupportEmailAddress = :councilSupportEmailAddress, whatGoesInBinURL = :whatGoesInBinURL, greenBinServiceName = :greenBinServiceName, greenBinAllowed = :greenBinAllowed, greenBinNotAllowed = :greenBinNotAllowed, greenBinIconURL = :greenBinIconURL, redBinServiceName = :redBinServiceName, redBinAllowed = :redBinAllowed, redBinNotAllowed = :redBinNotAllowed, redBinIconURL = :redBinIconURL, yellowBinServiceName = :yellowBinServiceName, yellowBinAllowed = :yellowBinAllowed, yellowBinNotAllowed = :yellowBinNotAllowed, yellowBinIconURL = :yellowBinIconURL, bringOutAfter = :bringOutAfter, bringOutBefore = :bringOutBefore
                WHERE contract = :contract";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":logoURL", $new["logoURL"] ?? $current["logoURL"], PDO::PARAM_STR);
        $stmt->bindValue(":primaryColor", $new["primaryColor"] ?? $current["primaryColor"], PDO::PARAM_STR);
        $stmt->bindValue(":secondaryColor", $new["secondaryColor"] ?? $current["secondaryColor"], PDO::PARAM_STR);
        $stmt->bindValue(":fbLink", $new["fbLink"] ?? $current["fbLink"], PDO::PARAM_STR);
        $stmt->bindValue(":twitterLink", $new["twitterLink"] ?? $current["twitterLink"], PDO::PARAM_STR);
        $stmt->bindValue(":igLink", $new["igLink"] ?? $current["igLink"], PDO::PARAM_STR);
        $stmt->bindValue(":websiteLink", $new["websiteLink"] ?? $current["websiteLink"], PDO::PARAM_STR);
        $stmt->bindValue(":councilSupportEmailAddress", $new["councilSupportEmailAddress"] ?? $current["councilSupportEmailAddress"], PDO::PARAM_STR);
        $stmt->bindValue(":whatGoesInBinURL", $new["whatGoesInBinURL"] ?? $current["whatGoesInBinURL"], PDO::PARAM_STR);
        $stmt->bindValue(":greenBinServiceName", $new["greenBinServiceName"] ?? $current["greenBinServiceName"], PDO::PARAM_STR);
        $stmt->bindValue(":greenBinAllowed", $new["greenBinAllowed"] ?? $current["greenBinAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":greenBinNotAllowed", $new["greenBinNotAllowed"] ?? $current["greenBinNotAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":greenBinIconURL", $new["greenBinIconURL"] ?? $current["greenBinIconURL"], PDO::PARAM_STR);
        $stmt->bindValue(":redBinServiceName", $new["redBinServiceName"] ?? $current["redBinServiceName"], PDO::PARAM_STR);
        $stmt->bindValue(":redBinAllowed", $new["redBinAllowed"] ?? $current["redBinAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":redBinNotAllowed", $new["redBinNotAllowed"] ?? $current["redBinNotAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":redBinIconURL", $new["redBinIconURL"] ?? $current["redBinIconURL"], PDO::PARAM_STR);
        $stmt->bindValue(":yellowBinServiceName", $new["yellowBinServiceName"] ?? $current["yellowBinServiceName"], PDO::PARAM_STR);
        $stmt->bindValue(":yellowBinAllowed", $new["yellowBinAllowed"] ?? $current["yellowBinAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":yellowBinNotAllowed", $new["yellowBinNotAllowed"] ?? $current["yellowBinNotAllowed"], PDO::PARAM_STR);
        $stmt->bindValue(":yellowBinIconURL", $new["yellowBinIconURL"] ?? $current["yellowBinIconURL"], PDO::PARAM_STR);
        $stmt->bindValue(":bringOutAfter", $new["bringOutAfter"] ?? $current["bringOutAfter"], PDO::PARAM_STR);
        $stmt->bindValue(":bringOutBefore", $new["bringOutBefore"] ?? $current["bringOutBefore"], PDO::PARAM_STR);

        $stmt->bindValue(":contract", $current["contract"], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $contract): int
    {
        $sql = "DELETE FROM contracts
                WHERE contract = :contract";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":contract", $id, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
