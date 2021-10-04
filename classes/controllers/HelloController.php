<?php
namespace SocymSlim\MVC\controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;

class HelloController
{
	private $container;

//=========================================================================================================

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

//=========================================================================================================

	public function sayHello(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		$content = "GitHubを利用してからのHelloWorld!";
		$responseBody = $response->getBody();
		$responseBody->write($content);
		return $response;
	}

//=========================================================================================================

	public function changerForKsc(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		// テンプレート変数を格納する連想配列を用意。
		$assign = [];
	
		$assign["name"] = "共和サービスセンター web メニュー";

		// プロテクト、ステートをテンプレート変数として格納。
		if (isset($args["pt"])) {
			if (($args["pt"] >= 1) and ($args["pt"] <= 2)) {
				$ptv = $args["pt"]; // プロテクト状態
			} else {
				$ptv = 1; // プロテクト状態=1 に固定
			}
		} else {
				$ptv = 1; // プロテクト状態=1 に固定
		}
		if (isset($args["st"])) {
			if (($args["st"] >= 0) and ($args["st"] <= 6)) {
				$stv = $args["st"]; // 状態番号
			} else {
				$stv = 1; // 状態番号=1 に固定
			}
		} else {
				$stv = 1; // 状態番号=1 に固定
		}
		$assign["protcMsg"] = $ptv; // プロテクト状態
		$assign["stateMsg"] = $stv; // 状態番号

		$twig = $this->container->get("view");
		$response = $twig->render($response, "changerForKsc.html", $assign);
		return $response;
	}

}
