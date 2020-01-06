<?php
namespace App\Controller\Admin;

/**
 * Backup Controller
 *
 */
class BackupController extends AppController
{

    public function descargar() 
    {
        $this->autoRender = false;
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        $source = \Cake\Datasource\ConnectionManager::get('default');

        $dbusername = $source->config()['username'];
        $dbpassword = $source->config()['password'];
        $dbname     = $source->config()['database'];
    
        $datestamp = date("Y-m-d-H-i");
        $nombre  = "Base-backup-$datestamp.sql.gz";
        $archivo = TMP . $nombre;
        
        $command = "mysqldump -u $dbusername --password='$dbpassword' $dbname | gzip > $archivo";
        $result  = passthru($command);

        $content = file_get_contents($archivo);

        if(!empty($archivo) AND is_file($archivo)){
            @unlink($archivo);
        }

        $this->response->body($content);
        $this->response->header('Content-Disposition', 'attachment; filename="' . $nombre . '"');
        return $this->response;
    }

}

