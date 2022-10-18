<?php
require_once dirname(__DIR__, 2) . "/src/Repository/ClassFeedRepository.php";

class Service 
{
    /* checkIfUserIsConnected
     * @return boolean
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
    }
    
    /* moveFile move uploaded file from temp folder
     * @params array $file
     * @return ?string
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
            $file_path_image = "/Montessori/public/assets/images/upload/" . $filename;
        }
        
        return $file_path_image;
    }

    /* renameFile
     * @params string $filename
     * @return string
     */
    private static function renameFile(string $filename): string
    {
        $array = explode(".", $filename);
        $date = new DateTime("now");
        $date = $date->format("Ymdhis");
        $filename = $date. "." ."png";
        return $filename;
    }
    
    /* filterInput
     * @params string $data
     * @return []
     */
    public static function filterInput(string $data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars(htmlspecialchars($data));
        
        $message = "success";
        if(str_contains($data, "&amp"))
        {
            $message = "error";
        }
        return [$data, $message];
    }


}