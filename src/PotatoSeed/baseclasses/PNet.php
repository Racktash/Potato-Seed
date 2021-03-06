<?php

class PNet
{
    public static function OneWayEncryption($pen, $key, $mode = "sha512")
    {
        $mode = strtolower($mode);//we don't care what case it is...
        switch ($mode)
        {
            case "md5":
                $encrypted_item = md5($pen);
                break;

            case "multi-md5":
                $en1 = md5($pen);
                $en2 = md5($en1);
                $en3 = md5($en2);
                $en4 = md5($en3);
                $en5 = md5($en4);
                $en6 = md5($en5);
                $en7 = md5($en6);
                $encrypted_item = $en7;
                break;
            
            case "sha512":
                if($key != NULL)
                {
                    $encrypted_item = hash_hmac("sha512", $pen, $key);
                }
                break;
        }
        return $encrypted_item;
    }
}

?>
