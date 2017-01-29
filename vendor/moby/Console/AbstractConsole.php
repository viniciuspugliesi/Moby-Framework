<?php

namespace Console;

use Console\Interfaces\InterfaceAbstractConsole;

class AbstractConsole implements InterfaceAbstractConsole
{
	/**
	 * Options font colors of the response
	 * @var array $colors
	 */ 
	private $colors = [
	    'black'         => '0;30',
        'dark_gray'     => '1;30',
        'blue'          => '0;34',
        'light_blue'    => '1;34',
        'green'         => '0;32',
        'light_green'   => '1;32',
        'cyan'          => '0;36',
        'light_cyan'    => '1;36',
        'red'           => '0;31',
        'light_red'     => '1;31',
        'purple'        => '0;35',
        'light_purple'  => '1;35',
        'brown'         => '0;33',
        'yellow'        => '1;33',
        'light_gray'    => '0;37',
        'white'         => '1;37',
        ''              => '1;37',
	];
	
	
	/**
	 * Options backgroud colors of the response
	 * @var array $background_colors
	 */ 
	private $background_colors = [
	    'black'     => '40',
        'red'       => '41',
        'green'     => '42',
        'yellow'    => '43',
        'blue'      => '44',
        'magenta'   => '45',
        'cyan'      => '46',
        'light_gray'=> '47',
        ''          => '40',
	];


	/**
	 * Response with personalized
	 * 
	 * @param string $string
	 * @param string $color
	 * @param string $background_color
	 * @return string
	 */ 
	public function responseColor($string, $color = 'white', $background_color = null)
	{
		$colored_response = "\033[" . $this->colors[$color] . "m";
	
		if ($this->background_colors[$background_color]) {
			$colored_response .= "\033[" . $this->background_colors[$background_color] . "m";
		}

		$colored_response .=  $string . "\033[0m";

		return $colored_response;
	}
	
	
	/**
	 * Return success message
	 * 
	 * @param int $code
	 * @return string
	 */
	public function getSuccessCommand($code = 1)
	{
        switch ($code) {
            case '1':
                return "     ///////                                                                             \n"
                      ."   //      ///                  ///                                                      \n"
                      ."  //         ////             ////     ////        ////  //////////  /////    //     //  \n"
                      ."///     //     //////      //////     // //      // //  //      //  //  //    //   //    \n"
                      ."////                /////////        //  //    //  //  //  //  //  //////     // //      \n"
                      ." ////////////       //////////      //   //  //   //  //  //  //  //  ///     //         \n"
                      ."  ///            ////    /////     //     ///    //  //      //  //   //     //          \n"
                      ."    ///////////////        /////  //            //  //////////  ///////     //           \n"
                      ."                              //                                                         \n\n"
                      
                      ."\033[0;36m Moby Framework \033[0m version \033[0;36m 1.0 \033[0m 2016/11/30 \n\n"
                        
                      ."\033[0;36m Usage: \033[0m \n"
                      ."   $ php moby command [options] [arguments] \n\n"
                        
                      ."\033[0;36m Need you Help?: \033[0m \n"
                      ."  \033[0;36m All helpers: \033[0m    $ php moby help \n"
                      ."  \033[0;36m Especific help: \033[0m $ php moby --help [options] \n\n"
                        
                      ."\033[0;36m Website: \033[0m       http://mobyframework.com \n"
                      ."\033[0;36m Documentation: \033[0m http://doc.mobyframework.com \n"
                      ."\033[0;36m Forum: \033[0m         http://forum.mobyframework.com \n"
                      ."\033[0;36m Github: \033[0m        https://github.com/viniciuspugliesi \n\n"
                        
                      ."\033[0;36m Creator: \033[0m       Vinicius Pugliesi \n"
                      ."\033[0;36m Website: \033[0m       http://viniciuspugliesi.com \n"
                      ."\033[0;36m Github: \033[0m        https://github.com/viniciuspugliesi \n\n\n";
                break;
                
            case '2':
                return "| ------------------------------------------------------------------- \n"
                    ."| ------------------------------------------------------------------- \n"
                    ."|   Console of Moby Framework \n"
                    ."| ------------------------------------------------------------------- \n"
                    ."| ------------------------------------------------------------------- \n"
                    ."|  \n"
                    ."|   \n"
                    ."|   Available commands: \n"
                    ."| ------------------------------------------------------------------- \n"
                    ."| \n"
                    ."|   $ php moby \n"
                    ."|       (Show information of Moby Framework) \n"
                    ."| \n"
                    ."|   $ php moby help \n"
                    ."|       (Show the avaliable commands for use) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:request {request-name} \n"
                    ."|       (Create one new Request) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:controller {controller-name} \n"
                    ."|       (Create one new Controller) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:model {model-name} \n"
                    ."|       (Create one new Model) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:model --database {table-name} \n"
                    ."|       (Create one new Model by table name) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:models --database \n"
                    ."|       (Create all Models according the database) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:crud --database {table-name} \n"
                    ."|       (Create new Crud by table name) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:cruds --database \n"
                    ."|       (Create all Cruds according the database) \n"
                    ."| ------------------------------------------------------------------- \n";
                break;
        }
	}
	
	
	/**
	 * Return error message
	 * 
	 * @param int $code
	 * @code string @comand
	 * @return string
	 */
	public static function getErrorComand($code = 1, $comand = null)
	{
        switch ($code) {
            case '1':
                return "Comand: $comand not found       \n"
                        ."                                  \n"
                        ."Need help?                        \n"
                        ."$ php moby help                   \n";
                        
                break;
            case '2':
                return '';
                
                break;
        }
	}
}