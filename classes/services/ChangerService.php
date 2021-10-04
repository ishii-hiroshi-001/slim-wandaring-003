<?php
namespace SocymSlim\MVC\services;

use Psr\Container\ContainerInterface;
use SocymSlim\MVC\daos\ChangerDAO;
use SocymSlim\MVC\exceptions\DataAccessException;

class ChangerService
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

	// 会員情報詳細表示に必要なデータを揃えるメソッド。
	public function showChangerDetailService(int $mbId): array
	{
		// テンプレート変数を格納する連想配列を用意。
		$assign = [];
		try {
			// PDOインスタンスをコンテナから取得。
			$db = $this->container->get("db");
			// ChangerDAOインスタンスをコンテナから取得。
			$changerDAO = $this->container->call("changerDAO", [$db]);
			// 主キーによる検索を実行。
			$changer = $changerDAO->findByPK($mbId);
			// データが存在した場合。
			if(isset($changer)) {
				//テンプレート変数としてChangerエンティティを格納。
				$assign["changerInfo"] = $changer;
			}
			// データが存在しなかった場合。
			else {
				$assign["msg"] = "指定の情報は存在しません。";
			}
		}
		// 例外処理。
		catch (PDOException $ex) {
			// 発生したPDOExceptionのコードを取得。
			$exCode = $ex->getCode();
			// 新たにDataAccessExceptionを発生。
			throw new DataAccessException("データベース処理中に障害が発生しました。", $exCode, $ex);
		}
		finally {
			// DB切断。
			$db = null;
		}
		return $assign;
	}
}
