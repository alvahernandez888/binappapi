<?php

class NewsGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT *
                FROM news";

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }


    public function create(array $data): string
    {
        $sql = "INSERT INTO news (postTitle, postContent, postDate, postExcerpt, category, featuredImageURL,active,scope)
                        VALUES (:postTitle, :postContent, :postDate, :postExcerpt, :category, :featuredImageURL, :active, :scope)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":postTitle", $data["postTitle"], PDO::PARAM_STR);
        $stmt->bindValue(":postContent", $data["postContent"], PDO::PARAM_STR);
        $stmt->bindValue(":postDate", $data["postDate"], PDO::PARAM_DATE);
        $stmt->bindValue(":postExcerpt", $data["postExcerpt"], PDO::PARAM_STR);
        $stmt->bindValue(":category", $data["category"], PDO::PARAM_STR);
        $stmt->bindValue(":featuredImageURL", $data["featuredImageURL"], PDO::PARAM_STR);
        $stmt->bindValue(":active", $data["active"], PDO::PARAM_INT);
        $stmt->bindValue(":scope", $data["scope"], PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $news_id): array | false
    {
        $sql = "SELECT *
                FROM news
                WHERE news_id = :news_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":news_id", $news_id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function update(array $current, array $new): int
    {
        $sql = "UPDATE news
                SET postTitle = :postTitle, postContent = :postContent, postDate = :postDate, postExcerpt = :postExcerpt, category = :category, featuredImageURL =:featuredImageURL, active = :active, scope = :scope
                WHERE news_id = :news_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":postTitle", $new["postTitle"] ?? $current["postTitle"], PDO::PARAM_STR);
        $stmt->bindValue(":postContent", $new["postContent"] ?? $current["postContent"], PDO::PARAM_STR);
        $stmt->bindValue(":postDate", $new["postDate"] ?? $current["postDate"], PDO::PARAM_STR);
        $stmt->bindValue(":postExcerpt", $new["postExcerpt"] ?? $current["postExcerpt"], PDO::PARAM_STR);
        $stmt->bindValue(":category", $new["category"] ?? $current["category"], PDO::PARAM_STR);
        $stmt->bindValue(":featuredImageURL", $new["featuredImageURL"] ?? $current["featuredImageURL"], PDO::PARAM_STR);
        $stmt->bindValue(":active", $new["active"] ?? $current["active"], PDO::PARAM_STR);
        $stmt->bindValue(":scope", $new["scope"] ?? $current["scope"], PDO::PARAM_STR);

        $stmt->bindValue(":news_id", $current["news_id"], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $news_id): int
    {
        $sql = "DELETE FROM news
                WHERE news_id = :news_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":news_id", $id, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
