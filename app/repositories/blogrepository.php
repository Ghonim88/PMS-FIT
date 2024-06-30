<?php
namespace Repositories;

use Models\Blog;

use PDO;

class BlogRepository extends Repository
{

  public function getAll($offset = NULL, $limit = NULL)
  {
    try {
      $sql = "SELECT contentId, header, subHeader, text, imageName FROM blog";
      if ($offset != NULL && $limit != NULL) {
        $sql .= " LIMIT $offset, $limit";
      }
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $blogs = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $blogs[] = self::getBlogFromRow($row);
      }
      return $blogs;
    } catch (\PDOException $e) {
      throw new \PDOException('Error getting blogs: ' . $e->getMessage());
    }
  }

  private static function getBlogFromRow($row)
  {
    return new Blog($row['contentId'], $row['header'], $row['subHeader'], $row['text'], $row['imageName']);
  }


  public function addContent(Blog $blog)
  {
    try {
      $stmt = $this->connection->prepare("
        INSERT INTO blog (header, subHeader, text, imageName)
        VALUES (:header, :subHeader, :text, :imageName)
      ");
      $params = [
        ':header' => $blog->getHeader(),
        ':subHeader' => $blog->getSubHeader(),
        ':text' => $blog->getText(),
        ':imageName' => $blog->getImageName()
      ];
      $stmt->execute($params);
    } catch (\PDOException $e) {
      throw new \PDOException('Error adding blog: ' . $e->getMessage());
    }
  }

  public function updateContent(Blog $blog)
  {
    try {
      $stmt = $this->connection->prepare("
        UPDATE blog
        SET header = :header, subHeader = :subHeader, text = :text, imageName = :imageName
        WHERE contentId = :contentId
      ");
      $params = [
        ':header' => $blog->getHeader(),
        ':subHeader' => $blog->getSubHeader(),
        ':text' => $blog->getText(),
        ':imageName' => $blog->getImageName(),
        ':contentId' => $blog->getContentId()
      ];
      $stmt->execute($params);
    } catch (\PDOException $e) {
      throw new \PDOException('Error updating blog: ' . $e->getMessage());
    }
  }

  public function deleteContent($contentId)
  {
    try {
      $stmt = $this->connection->prepare("
        DELETE FROM blog
        WHERE contentId = :contentId
      ");
      $stmt->bindParam(':contentId', $contentId, PDO::PARAM_INT);
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \PDOException('Error deleting blog: ' . $e->getMessage());
    }
  }

  public function getContentById($contentId)
  {
    try {
      $stmt = $this->connection->prepare("
        SELECT contentId, header, subHeader, text, imageName
        FROM blog
        WHERE contentId = :contentId
      ");
      $stmt->bindParam(':contentId', $contentId, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return self::getBlogFromRow($row);
    } catch (\PDOException $e) {
      throw new \PDOException('Error getting blog: ' . $e->getMessage());
    }
  }
}