<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/src/Repository/ArticlesRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/UserRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/CategoryRepository.php";
require_once dirname(__DIR__, 2) . "/src/service/Service.php";

class ArticlesController extends AbstractController
{
    /**
     * @var ArticleRepository $articleRepository
     */
    private ArticlesRepository $articleRepository;

    /**
     * @var UserRepository $userRepository
     */
    private UserRepository $userRepository;
    
    /**
     * @var CategoryRepository $categoryRepository
     */
    private CategoryRepository $categoryRepository;

    

    public function __construct()
    {
        $this->articleRepository = new ArticlesRepository();
        $this->userRepository = new UserRepository();
        $this->categoryRepository = new CategoryRepository();
        
    }
        
    /*
    * @return string utilise la methode renderView() définie dans la classe 
    * abstrait parent abstractController 
    */
    public function index(): string
    {
        $articles = [];
        $articles = $this->articleRepository->findAll();
     
        return $this->renderView("/template/article/article_base.phtml", ["articles" => $articles]);
        
        //"articles" => $this->articleRepository->findAll()
        
    }//end function index
    
    /*
    * @return article, user and category information
    */
    public function show()
    {
        $article = null;
        $user = null ;
        $category = [];
    
        if(isset($_GET['article_id'])){
            
            $article = $this->articleRepository->findOne($_GET['article_id']);
            $user = $this->userRepository->retrieve($article->getUserId());
            $category = $this->categoryRepository->findByArticle($_GET['article_id']);
            
            return $this->renderView("/template/article/article_show.phtml", [
                "article" => $article,
                "user" => $user,
                "categories"=> $category
                ]
            );
        }
        
    }//end function show

    /*
    * @return category list (dynamic) and show add article page 
    */
    public function add()
    {   
        $categoryRepository = $this->categoryRepository->findAll();
        
        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=home");
        }
        if (Service::checkIfUserIsConnected())
        {
            if(
            !empty($_POST)
            && isset($_POST["article_title"])
            && isset($_POST["article_categories"])
            && isset($_POST["article_content"])
            && ($imagePath = Service::moveFile($_FILES["article_image"]))
            && ($categories = Service::categoryExists(($_POST["article_categories"])))
            ) 
            {
            //$notError=false;
            //$message="Les informations fournies ne sont pas valables.";
            
           
            $article = new Article();
            $article->setTitle(trim($_POST["article_title"]));
            $article->setContent(trim($_POST["article_content"]));
            $article->setImage($imagePath);
            
            $date_published = "";
            $date_published = new DateTime("now");
            $date_published = $date_published->format("Y-m-d H:i:s");
            $article->setPublishedDate($date_published);
            
            $article->setUserId(intval($_SESSION['user_id']));
            
            $articleRepository->add($article);
            $article = $articleRepository->findLast();

            foreach($categories as $key=>$category_id)
            {
                $this->articleRepository->insertArticleCategories($article, $category_id);
            }
            
            header("Location: ?page=articles");
            }

            
            return $this->renderView("/template/article/article_add.phtml", ["categoryList"=>$categoryRepository]);

        }

    }//end function add
    
    public function delete()
    {
        if (
            Service::checkIfUserIsConnected()
            && isset($_GET["article_id"])
            && $article = $this->articleRepository->findOne(intval($_GET["article_id"]))
        ) {
            var_dump($article->getFile_path_image());
            //supprime l'image lié à l'article 
            unlink(dirname(__DIR__, 3) . $article->getFile_path_image());
            // supprime l'article
            //$this->articleCategoryRepository->deleteByArticle($article);
            $this->articleRepository->delete($article);
            // Redirect vers la page listant les articles 
             header("Location: ?page=articles");
        }
           
    }//end function deleted
}

