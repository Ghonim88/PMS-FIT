<?php

namespace Services; 

use Repositories\BlogRepository;

class BlogService {
    private $blogRepository;

    function __construct()
    {
        $this->blogRepository = new BlogRepository();
    }

    public function getAll($offset = NULL, $limit = NULL) { 
         return $this->blogRepository->getAll($offset, $limit);
    }

    public function addContent($blog) {
        return $this->blogRepository->addContent($blog);
    }
    public function deleteContent($contentId) {
        return $this->blogRepository->deleteContent($contentId);
    }
    public function updateContent($blog) {
        return $this->blogRepository->updateContent($blog);
    }
    public function getContent($contentId) {
        return $this->blogRepository->getContentById($contentId);
    }

}
