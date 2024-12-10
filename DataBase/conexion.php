<?php


    class conexionDB {
       
        
        public static function execute($scriptSQL){
            try {
                    //conexion esto se cambia 
                $conexion = mysqli_connect(
                    'localhost',
                    'root',
                    '258510',
                    'MyBalance'
                ) or die ('No se puede conectar a la base de datos');

                $instruccionSQL = mysqli_query($conexion, $scriptSQL);
                $resultado = array(
                    'exito' => $instruccionSQL,
                    'error' => mysqli_error($conexion),
                    'conexion' => $conexion


                );

                return $resultado;

            } catch (Exception $e) {
                echo "error:" . $e->getMessage();
            }

        }

        public static function getData($scriptSQL){
            try{

                $resultado = self ::execute($scriptSQL);
                $registros = array();

                    if ($resultado['exito']) {

                        while($fila = mysqli_fetch_array($resultado['exito'], MYSQLI_ASSOC)){
                            $registros[] =$fila;
                        }

                        self::desconectar($resultado['conexion'], $resultado['exito']);

                    }

                    return $registros;


            }catch (Exception $e) {
                echo "error:" . $e->getMessage();
            }


        }




        public static function desconectar($conexion, $resultado) {
            try {

                if ($resultado instanceof mysqli_result){
                    mysqli_free_result($resultado);

                }
                mysqli_close($conexion);

            } catch (Exception $e) {
                echo "error:" . $e->getMessage();
            }

         }

                public static function getNotificaciones($resultado, $mensaje){
                    if($resultado['exito']) {

                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Exito!</strong> '. $mensaje.'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';

                    } else{

                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>ERROR!</strong> '. $mensaje.'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';

                    }
                }

            }
        
    


?>