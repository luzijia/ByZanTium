<?php

//Route->set(
//  Array("/videoAudit/getList/{page}/{$page}/{date}/{$date}/{cate}/{$cate}"=>"admin/VideoAuditController")
//  // /VideoAudit/getList/page/1/cate/2
//  // $_GET['page'] = 1
//     $_GET['cate'] = 2;
//  //rewrite
//)
namespace Component\Router;

#美化URI支持多少个参数对，默认支持6组参数
define('SELF_PARAMES_LENGTH',6);

class Route
{
    protected $datas = array();

    public function __construct()
    {
        $this->datas = \AutoLoad::import(PRJ_PATH."config/router.php");

        return $this;
    }

    public function ruleRoute(\Component\Http\Request $request)
    {

        $uri        = $request->uri->getPath();

        $module     = $controller = $action = '';

        $params     = [];

        if(isset($this->datas[$uri])){
            $module     = $this->datas[$uri][0];
            $controller = $this->datas[$uri][1];
            $action     = $this->datas[$uri][2];
            $params     = [];

        }else{
            foreach($this->datas as $pattern=>$data)
            {
                $pattern = $this->makePregRex($pattern);
                $ret  = preg_match($pattern,$uri,$matches);
                if($ret>0)
                {
                    $module     = $data[0];
                    $controller = strip_tags(ucfirst($data[1]));
                    $action     = strip_tags(ucfirst($data[2]));
                    $params     = $this->makePregParams($matches,$request);
                }
            }
        }
        return ["m"=>$module,"c"=>$controller,"a"=>$action,'p'=>$params];
    }

    private function makePregParams($matches,$request)
    {
        $matches = array_slice($matches,1);

        $params = array();

        for($ix=0;$ix<SELF_PARAMES_LENGTH * 2-1;$ix++)
        {
            $key = $ix;
            $val = $ix+1;

            $even = $ix % 2 == 0;

            if($even and isset($matches[$val]) and $matches[$val]){
                $params[$matches[$key]]=$matches[$val];
            }
        }

        return $params;
    }

    private function  makePregRex($pattern)
    {
        return '{^'.rtrim($pattern,'/').'}';
    }
}
