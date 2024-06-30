<?php

namespace Controllers;

use Exception;
use Services\BlogService;
use Models\Blog;

class BlogController extends Controller
{

  private $blogService;

  function __construct()
  {
    $this->blogService = new BlogService();
  }

  public function getAllContent($offset = NULL, $limit = NULL)
  {
    try {
      $blogs = $this->blogService->getAll($offset, $limit);
      $blogsArray = array_map(function ($blog) {
        return $blog->toArray();
      }, $blogs);
      // var_dump($blogs);
      $this->respond($blogsArray);

    } catch (Exception $e) {
      $this->respondWithError(500, $e->getMessage());
    }

  }

  public function addContent()
  {
    try {
      header('Access-Control-Allow-Origin: http://localhost:5173');
      header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
      header('Access-Control-Allow-Headers: token, Content-Type');

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $header = $_POST['header'];
        $subHeader = $_POST['subHeader'];
        $text = $_POST['text'];
        $imageName = '';

        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
          // Check file size - 5MB maximum
          $maxSize = 5 * 1024 * 1024;
          if ($_FILES['image']['size'] > $maxSize) {
            throw new Exception('The image is too large. Please upload an image smaller than 5MB.');
          }

          $targetDir = "img/";
          $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
          $targetFilePath = $targetDir . $imageName;

          if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            throw new Exception('Failed to upload the image.');
          }
        }

        $content = new Blog(null, $header, $subHeader, $text, $imageName);
        $this->blogService->addContent($content);
        $this->respond(['message' => 'Content added']);
      }
    } catch (Exception $e) {
      $this->respondWithError(500, $e->getMessage());
    }
  }


  public function updateContent()
  {
    try {
      $contentId = $_POST['contentId'];
      $header = $_POST['header'];
      $subHeader = $_POST['subHeader'];
      $text = $_POST['text'];

      $oldContent = $this->blogService->getContent($contentId);
      $oldImageName = $oldContent->getImageName();
      $imageName = $_POST['imageName'] ?? $oldImageName;


      // Handle the file upload
      if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        if ($file['error'] == UPLOAD_ERR_OK) {
          $maxSize = 5 * 1024 * 1024;
          if ($file['size'] > $maxSize) {
            throw new Exception('The image is too large. Please upload an image smaller than 5MB.');
          }

          $targetDir = "img/";
          $imageName = uniqid() . '-' . basename($file['name']);
          $targetFilePath = $targetDir . $imageName;

          if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            throw new Exception('Failed to upload the image.');
          }

          // If the image has been changed, remove the old image
          if ($imageName !== $oldImageName && !empty($oldImageName)) {
            
            if (!unlink($targetDir . $oldImageName)) {
              throw new Exception('Failed to delete the old image.');
            }
          } 
        }
      }else {
        // If no new image is provided, keep the old image name
        $imageName = $oldImageName;
      }

      $content = new Blog($contentId, $header, $subHeader, $text, $imageName);
      $this->blogService->updateContent($content);
      $this->respond(['message' => 'Content updated']);
    } catch (Exception $e) {
      $this->respondWithError(500, $e->getMessage());
    }
  }

  public function deleteContent()
  {
    try {
      $json = file_get_contents('php://input');
      $data = json_decode($json, true);
      // var_dump($data);
      $contentId = $data['contentId'];

      $this->blogService->deleteContent($contentId);
      $this->respond(['message' => 'Content deleted']);
    } catch (Exception $e) {
      $this->respondWithError(500, $e->getMessage());
    }
  }

}
