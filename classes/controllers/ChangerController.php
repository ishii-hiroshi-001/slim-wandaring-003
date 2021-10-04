<?php
namespace SocymSlim\MVC\controllers;

use PDO;
use PDOException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use SocymSlim\MVC\entities\Changer;
use SocymSlim\MVC\daos\ChangerDAO;
use SocymSlim\MVC\exceptions\DataAccessException;
use SocymSlim\MVC\services\ChangerService;

class ChangerController
{
	// コンテナインスタンス
	private $container;

//=========================================================================================================

	// コンストラクタ
	public function __construct(ContainerInterface $container)
	{
		// 引数のコンテナインスタンスをプロパティに格納。
		$this->container = $container;
	}
//=========================================================================================================

	// 納期変更の登録画面を表示するメソッド。
	public function goChangerApp(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		// テンプレート変数を格納する連想配列を用意。
		$assign = [];

		// プロテクト、ステート、フラグをテンプレート変数として格納。
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
		if (isset($args["fl"])) {
			if (($args["fl"] >= 1) and ($args["fl"] <= 2)) {
				$flv = $args["fl"]; // 表示フラグ
			} else {
				$flv = 1; // 表示フラグ=1 に固定
			}
		} else {
				$flv = 1; // 表示フラグ=1 に固定
		}
		$assign["protcMsg"] = $ptv; // プロテクト状態
		$assign["stateMsg"] = $stv; // 状態番号
		$assign["dflagMsg"] = $flv; // 表示フラグ

		// コンテナからフラッシュメッセージ用のMessagesインスタンスを取得。
		$flash = $this->container->get("flash");

		// 全てのフラッシュメッセージを取得。
		$flashMessages = $flash->getMessages();

		// フラッシュメッセージが存在するならば…
		if(isset($flashMessages)) {
			// キーflashMsgで格納されたフラッシュメッセージを取得。
			$flashMsg = $flash->getFirstMessage("flashMsg");

			// フラッシュメッセージをテンプレート変数として格納。
			$assign["flashMsg"] = $flashMsg;
		}
		try {
			// PDOインスタンスをコンテナから取得。
			$db = $this->container->get("db");

			// ChangerDAOインスタンスを生成。
			$changerDAO = new ChangerDAO($db);

			// URL中のパラメータを取得。
			$changerList = $changerDAO->findChanger($stv, $flv);
		}
		// 例外処理。
		catch(PDOException $ex) {

			// 障害発生メッセージを作成。
			$assign["msg"] = "障害が発生しました。";
			var_dump($ex);
		}
		finally {
			// DB切断。
			$db = null;
		}

		//テンプレート変数として会員情報リストを格納。
		$assign["changerList"] = $changerList;

		// Twigインスタンスをコンテナから取得。
		$twig = $this->container->get("view");

		// changerApp.htmlをもとにしたレスポンスオブジェクトを生成。
		$response = $twig->render($response, "changerApp.html", $assign);

		// レスポンスオブジェクトをリターン。
		return $response;
	}

//=========================================================================================================

	// 会員情報登録メソッド。
	public function changerApp(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		// リダイレクトさせるかどうかのフラグ。
		$isRedirect = false;

		// リクエストパラメータを取得。
		$postParams = $request->getParsedBody();

		$addCgStat = 1; // $postParams["addCgStat"];

		$addCgIraiNo = $postParams["addCgIraiNo"];
		$addCgTantouName = $postParams["addCgTantouName"];
		$addCgKatasikiName = $postParams["addCgKatasikiName"];

		$addCgNoukimaeDate = $postParams["addCgNoukimaeDate"];
		$addCgNoukiatoDate = $postParams["addCgNoukiatoDate"];

		$addCgHenkoCount = $postParams["addCgHenkoCount"];
		$addCgRiyuu1No = $postParams["addCgRiyuu1No"];
		$addCgRiyuu2No = $postParams["addCgRiyuu2No"];

		$addCgOkureComent = $postParams["addCgOkureComent"];
		$addCgKaesiComent = $postParams["addCgKaesiComent"];

		$addCgShinseiStart = date("Y-m-d"); // $postParams["addCgShinseiStart"];
		$addCgSyouninDate = $postParams["addCgSyouninDate"];
		$addCgSyoriDate= $postParams["addCgSyoriDate"];
		$addCgCheckDate = $postParams["addCgCheckDate"];

		// リクエストパラメータをエンティティに格納。
		$changer = new Changer();

		$changer->setCgStat($addCgStat);

		$changer->setCgIraiNo($addCgIraiNo);
		$changer->setCgTantouName($addCgTantouName);
		$changer->setCgKatasikiName($addCgKatasikiName);

		$changer->setCgNoukimaeDate($addCgNoukimaeDate);
		$changer->setCgNoukiatoDate($addCgNoukiatoDate);

		$changer->setCgHenkoCount($addCgHenkoCount);
		$changer->setCgRiyuu1No($addCgRiyuu1No);
		$changer->setCgRiyuu2No($addCgRiyuu2No);

		$changer->setCgOkureComent($addCgOkureComent);
		$changer->setCgKaesiComent($addCgKaesiComent);

		$changer->setCgShinseiStart($addCgShinseiStart);
		$changer->setCgSyouninDate($addCgSyouninDate);
		$changer->setCgSyoriDate($addCgSyoriDate);
		$changer->setCgCheckDate($addCgCheckDate);

		try {
			// PDOインスタンスをコンテナから取得。
			$db = $this->container->get("db");

			// ChangerDAOインスタンスを生成。
			$changerDAO = new ChangerDAO($db);

			// データ登録。
			$cgId = $changerDAO->insertChanger($changer);

			// SQL実行が成功した場合。
			if($cgId !== -1) {
				// コンテナからフラッシュメッセージ用のMessagesインスタンスを取得。
				$flash = $this->container->get("flash");

				// 成功メッセージをフラッシュメッセージとして格納。
				$flash->addMessage("flashMsg", "ID ".$cgId."で登録が完了しました。");

				// リダイレクトフラグをONに。
				$isRedirect = true;
			}
			// SQL実行が失敗した場合。
			else {
				// 失敗メッセージを格納したDataAccessExceptionを発生。
				throw new DataAccessException("登録に失敗しました。");
			}
		}
		// 例外処理。
		catch(PDOException $ex) {

			// 発生したPDOExceptionのコードを取得。
			$exCode = $ex->getCode();

			// 新たにDataAccessExceptionを発生。
			throw new DataAccessException("データベース処理中に障害が発生しました。", $exCode, $ex);
		}
		finally {
			// DB切断。
			$db = null;
		}

		// リダイレクトフラグONならば…
		if($isRedirect) {
			// リスト表示へリダイレクト。
			$response = $response->withHeader("Location", "/goChangerApp/1/1/1");
			$response = $response->withStatus(302);
		}
		// リダイレクトフラグOFFならば…
		else {
			//バリデーションなどで元の入力画面を表示させるなど、リダイレクト以外の画面表示処理の場合はここにコードを記述する。
		}

		// レスポンスオブジェクトをリターン。
		return $response;
	}

//=========================================================================================================

	// 納期変更の詳細表示メソッド。
	public function showChangerSet(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		// リダイレクトさせるかどうかのフラグ。
		$isRedirect = false;

		// URL中のパラメータを取得。
		$cgSt = $args["st"]; // 状態番号
		$cgVl = $args["vl"]; // 設定値
		$cgId = $args["id"]; // レコードのID
		$cgCt = $args["ct"]; // 表示の列番号

		// リクエストパラメータを取得。
		$postParams = $request->getParsedBody();

		// コメントを設定。
		$addCgKaesiComent = $postParams["addCgKaesiComent".$cgCt];

		// リクエストパラメータをエンティティに格納。
		$changer = new Changer();

		$changer->setCgKaesiComent($addCgKaesiComent);

		try {
			// PDOインスタンスをコンテナから取得。
			$db = $this->container->get("db");

			// ChangerDAOインスタンスを生成。
			$changerDAO = new ChangerDAO($db);

			// データ登録。
			$cgId = $changerDAO->replChanger($cgSt, $cgVl, $cgId, $changer);

			// SQL実行が成功した場合。
			if($cgId !== -1) {
				// コンテナからフラッシュメッセージ用のMessagesインスタンスを取得。
				$flash = $this->container->get("flash");

				// 成功メッセージをフラッシュメッセージとして格納。
				$flash->addMessage("flashMsg", "ID=(".$cgId.") STAUTS=(".$cgSt.",".$cgVl.")で、登録が完了しました。");

				// リダイレクトフラグをONに。
				$isRedirect = true;
			}
			// SQL実行が失敗した場合。
			else {
				// 失敗メッセージを格納したDataAccessExceptionを発生。
				throw new DataAccessException("登録に失敗しました。");
			}
		}
		// 例外処理。
		catch(PDOException $ex) {

			// 発生したPDOExceptionのコードを取得。
			$exCode = $ex->getCode();

			// 新たにDataAccessExceptionを発生。
			throw new DataAccessException("データベース処理中に障害が発生しました。", $exCode, $ex);
		}
		finally {
			// DB切断。
			$db = null;
		}

		// リダイレクトフラグONならば…
		if($isRedirect) {
			// リスト表示へリダイレクト。
			$response = $response->withHeader("Location", "/goChangerApp/2/$cgSt/1");
			$response = $response->withStatus(302);
		}
		// リダイレクトフラグOFFならば…
		else {
			// バリデーションなどで元の入力画面を表示させるなど、リダイレクト以外の画面表示処理の場合はここにコードを記述する。
		}

		// レスポンスオブジェクトをリターン。
		return $response;
	}

//=========================================================================================================

	// 納期変更のリスト表示メソッド
	public function showChangerList(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		// テンプレート変数を格納する連想配列を用意。
		$assign = [];

		// コンテナからフラッシュメッセージ用のMessagesインスタンスを取得。
		$flash = $this->container->get("flash");

		// 全てのフラッシュメッセージを取得。
		$flashMessages = $flash->getMessages();

		// フラッシュメッセージが存在するならば…
		if(isset($flashMessages)) {
			// キーflashMsgで格納されたフラッシュメッセージを取得。
			$flashMsg = $flash->getFirstMessage("flashMsg");

			// フラッシュメッセージをテンプレート変数として格納。
			$assign["flashMsg"] = $flashMsg;
		}
		try {
			// PDOインスタンスをコンテナから取得。
			$db = $this->container->get("db");

			// ChangerDAOインスタンスを生成。
			$changerDAO = new ChangerDAO($db);

			// 全件データを取得。
			$changerList = $changerDAO->findChanger(7,1);
		}
		// 例外処理。
		catch(PDOException $ex) {
			// 障害発生メッセージを作成。
			$assign["msg"] = "障害が発生しました。";
			var_dump($ex);
		}
		finally {
			// DB切断。
			$db = null;
		}

		//テンプレート変数として会員情報リストを格納。
		$assign["changerList"] = $changerList;

		// Twigインスタンスをコンテナから取得。
		$twig = $this->container->get("view");

		// changerApp.htmlをもとにしたレスポンスオブジェクトを生成。
		$response = $twig->render($response, "changerList.html", $assign);

		// レスポンスオブジェクトをリターン。
		return $response;
	}

//=========================================================================================================

	// 納期変更の情報をJSONとして取得するメソッド。
	public function getAllChangersJSON(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		try {
			// PDOインスタンスをコンテナから取得。
			$db = $this->container->get("db");
	
			// ChangerDAOインスタンスをコンテナから取得。
			$changerDAO = $this->container->call("ChangerDAO", [$db]);
	
			// 全データを連想配列として取得。
			$allList = $changerDAO->findAll2Array();
	
			// SQL実行が成功した場合。
			if(!empty($allList)) {
				// 成功メッセージをJSON用配列に格納。
				$jsonArray["msg"] = "データ取得に成功しました。";

				// JSON用配列に全データ連想配列を格納。
				$jsonArray["Changers"] = $allList;
			}
			// SQL実行が失敗した場合。
			else {
				// 失敗メッセージをJSON用配列に格納。
				$jsonArray["msg"] = "データ取得に失敗しました。";
			}
		}
		// 例外処理。
		catch(PDOException $ex) {
			// 障害発生メッセージをJSON用配列に格納。
			$jsonArray["msg"] = "障害が発生しました。";
		}
		finally {
			// DB切断。
			$db = null;
		}

		// JSON用配列をエンコード。
		$jsonData = json_encode($jsonArray);

		// JSONデータをレスポンスオブジェクトに格納。
		$responseBody = $response->getBody();
		$responseBody->write($jsonData);

		// コンテントタイプをJSONに設定。
		$response = $response->withHeader("Content-Type", "application/json");

		// レスポンスオブジェクトをリターン。
		return $response;
	}

}
