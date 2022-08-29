<?php
require_once dirname(__DIR__, 2) . "/src/Repository/CategoryRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/UserRepository.php";

class Service 
{
    
    /*
    * @return if user connected
    */
    public static function checkIfUserIsConnected() :bool
    {
        $isUserConnected = false;
        $userRepository = new UserRepository();
        
        if (isset($_SESSION['login'], $_SESSION["user_id"])
            && $_SESSION['login'] 
            && $userRepository->retrieve(intval ($_SESSION["user_id"])))
        {
            $isUserConnected = true;
        }
        
        return $isUserConnected;
        
    }//end function checkIfUserIsConnected
    

    /*
    * permet de déplacer le fichier upload du dossie tmp à son dossier finale
    */
    public static function moveFile(array $file): ?string
    {
        
        $file_path_image = null;
        $folder = dirname(__DIR__,2) . "/public/assets/images/upload/";
        
        if (!file_exists($folder)) 
        {
            mkdir($folder, 0777);
        }
        
        $filename = self::renameFile($file["name"]);
        
        if (move_uploaded_file($file["tmp_name"], $folder . $filename))
        {
            $file_path_image = "/Blog/public/assets/images/upload/" . $filename;
        }
        
        return $file_path_image;
       
    }//end function moveFile

    /*
    * vérifie si la categorie existe et renvoie un array contenant les categories existant
    */
    public static function categoryExists(array $categoriesSearched): ?array
    {
        foreach($categoriesSearched as $key)
        {
            $categoryExists = null;
            $categoryRepository = new CategoryRepository();
            $category = $categoryRepository->findCategory($key);
            
            //if it doesn't exist, remove
            if($category)
            {
                $categoryExists=[];
                array_push($categoryExists, $category);
            }
        }
        
        //return updated array
        return $categoryExists;
        
    }//end function checkCategoriesExist

    /*
    * renomme le fichier selon un new DateTime("now"))->format("Ymdhis") et 
    * l'extention de fichier (.png)
    */

    private static function renameFile(string $filename): string
    {
        $array = explode(".", $filename);
        
        $d = new DateTime("now");
        $d2 = $d->format("Ymdhis");
        
        $filename = $d2. "." ."png";
        
        return $filename;
        
    }//en function renameFile

}