<?php 

namespace App\Services;

use Fluent\Auth\Helpers\Str;

class ImageService
{
    public static function storeImages(
        array|object $images,
        string $pathToStore,
        string|int $propertyKey = 'protertyKey',
        string|int $propertyValue = 'null',

    ): array
    {
        // É apenas uma imagem ( obejto de uma imagem 'upada')
        if(is_object($images)){

            self::worksWithImage($images, $pathToStore);

        }
        // string $uploadedImages recebe um array vazio 
        $uploadedImages =[];

        // Temos um array de imagens que retorna a posição 'images' que pecorreremos usando '$image'

        foreach($images['images'] as $image){

            $uploadedImages[] = [
                $propertyKey => $propertyValue,
                'image'      => self::worksWithImage($image, $pathToStore) ,
            ];              

        }
        //retorna o array de imagens uploaded
        return $uploadedImages;

    }

    public static function showImage(string $imagePath, string $image, string $sizeImage = 'regular')
    {
        if($sizeImage=='small'){
            //caminho da pasta small
            $imagePath = WRITEPATH."uploads/$imagePath/small/$image";

        }else{
            //caminho da pasta original
            $imagePath = WRITEPATH."uploads/$imagePath/$image";

        }

        $fileInfo = new \finfo(FILEINFO_MIME);

        $fileType = $fileInfo->file($imagePath);

        header("Content-Type: $fileType");
        header("Content-Length:". filesize($imagePath));

        readfile($imagePath);

        exit;

    }

    public static function destroyImage(string $pathToImage, string $imageToDestroy)
    {
        $regularImageToDestroy = WRITEPATH . "uploads/$pathToImage/$imageToDestroy";
        
        $smallImageToDestroy = WRITEPATH . "uploads/$pathToImage/small/$imageToDestroy";

        if(is_file($regularImageToDestroy)){

            unlink($regularImageToDestroy);

        }

        if(is_file($smallImageToDestroy)){
            
            unlink($smallImageToDestroy);

        }

    }

    private static function worksWithimage(object $image, string $pathToStore): string
    {
        // nesse ponto armazenamos a imagem no caminho informado
        $imagePath = $image->store($pathToStore);

        // camiho completo de onde foi armazenada o arquivo
        $imagePath = WRITEPATH . "uploads/$imagePath";

        // camiho completo de onde foi armazenada o arquivo small
        $imageSmallPath = WRITEPATH . "uploads/$pathToStore/small/";

        //Existe o diretorio contido na variavel $imageSmallPath?
        if(!is_dir($imageSmallPath)){

            // Não existe, Então podemos cria-los
            mkdir($imageSmallPath);

        }
        //Manipulamos a imagem para criarmos um a copia menor que a original
        
        service('image')
            ->withFile($imagePath) // arquivo original
            ->resize(275, 275, false, 'higth') // redefinimos o tamanho da imagem mantendo a qualidade da imagem
            ->save($imageSmallPath.$image->getName()); // salvamos no caminho small com o nome

            //retorna o nome da imagem
            return $image->getName();
    } 

    


}