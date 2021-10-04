<?php
namespace SocymSlim\MVC\daos;

use PDO;
use SocymSlim\MVC\entities\Changer;

class ChangerDAO
{
	// PDOインスタンスを表すプロパティ。
	private $db;

//=========================================================================================================

	// コンストラクタ。
	public function __construct(PDO $db)
	{
		// 引数をプロパティに格納。
		$this->db = $db;
	}

//=========================================================================================================

	// データ登録メソッド。
	public function insertChanger(Changer $changer): int
	{
		//登録用SQL文字列を用意。
		$sqlInsert = "INSERT INTO changers (cg_stat, cg_irai_no, cg_tantou_name, cg_katasiki_name, cg_noukimae_date, cg_noukiato_date, cg_henko_count, cg_riyuu1_no, cg_riyuu2_no, cg_okure_coment, cg_kaesi_coment, cg_shinsei_start, cg_syounin_date, cg_syori_date, cg_check_date) VALUES (:cg_stat, :cg_irai_no, :cg_tantou_name, :cg_katasiki_name, :cg_noukimae_date, :cg_noukiato_date, :cg_henko_count, :cg_riyuu1_no, :cg_riyuu2_no, :cg_okure_coment, :cg_kaesi_coment, :cg_shinsei_start, :cg_syounin_date, :cg_syori_date, :cg_check_date)";

		// プリペアドステートメントインスタンスを取得。
		$stmt = $this->db->prepare($sqlInsert);

		// 変数をバインド。
		$stmt->bindValue(":cg_stat", $changer->getCgStat(), PDO::PARAM_INT);

		$stmt->bindValue(":cg_irai_no", $changer->getCgIraiNo(), PDO::PARAM_STR);
		$stmt->bindValue(":cg_tantou_name", $changer->getCgTantouName(), PDO::PARAM_STR);
		$stmt->bindValue(":cg_katasiki_name", $changer->getCgKatasikiName(), PDO::PARAM_STR);

		$stmt->bindValue(":cg_noukimae_date", $changer->getCgNoukimaeDate(), PDO::PARAM_STR);
		$stmt->bindValue(":cg_noukiato_date", $changer->getCgNoukiatoDate(), PDO::PARAM_STR);

		$stmt->bindValue(":cg_henko_count", $changer->getCgHenkoCount(), PDO::PARAM_STR);
		$stmt->bindValue(":cg_riyuu1_no", $changer->getCgRiyuu1No(), PDO::PARAM_STR);
		$stmt->bindValue(":cg_riyuu2_no", $changer->getCgRiyuu2No(), PDO::PARAM_STR);

		$stmt->bindValue(":cg_okure_coment", $changer->getCgOkureComent(), PDO::PARAM_STR);
		$stmt->bindValue(":cg_kaesi_coment", $changer->getCgKaesiComent(), PDO::PARAM_STR);

		$stmt->bindValue(":cg_shinsei_start", $changer->getCgShinseiStart(), PDO::PARAM_STR);
		$stmt->bindValue(":cg_syounin_date", $changer->getCgSyouninDate(), PDO::PARAM_STR);
		$stmt->bindValue(":cg_syori_date", $changer->getCgSyoriDate(), PDO::PARAM_STR);
		$stmt->bindValue(":cg_check_date", $changer->getCgCheckDate(), PDO::PARAM_STR);

		// SQLの実行。
		$result = $stmt->execute();

		// 戻り値となる連番主キー値を初期値-1で用意。
		$cgId = -1;

		// SQL実行が成功した場合。
		if($result) {
			// 連番主キーを取得。
			$cgId = $this->db->lastInsertId();
		}

		return $cgId;
	}

//=========================================================================================================

	// 検索メソッド。
	public function findChanger(int $stv,int $flv): array
	{
		// 納期リストを格納する連想配列の用意。
		$changerList = [];

		// データ取得SQL文字列を用意。
		if        ($stv == 0)  {
			$sqlSelect = "SELECT * FROM changers WHERE cg_stat = 0 ORDER BY id DESC LIMIT 20";
		} elseif (($stv == 1) && ($flv == 1)) {
			$sqlSelect = "SELECT * FROM changers WHERE cg_stat = 1 ORDER BY cg_shinsei_start,id";
		} elseif (($stv == 1) && ($flv == 2)) {
			$sqlSelect = "SELECT * FROM changers WHERE cg_stat = 1 ORDER BY cg_irai_no";
		} elseif  ($stv == 2) {
			$sqlSelect = "SELECT * FROM changers WHERE cg_stat = 1 ORDER BY cg_shinsei_start,id";
		} elseif  ($stv == 3) {
			$sqlSelect = "SELECT * FROM changers WHERE cg_stat = 2 ORDER BY cg_shinsei_start,id";
		} elseif  ($stv == 4) {
			$sqlSelect = "SELECT * FROM changers WHERE cg_stat = 3 ORDER BY cg_shinsei_start,id";
		} elseif  ($stv == 5) {
			$sqlSelect = "SELECT * FROM changers WHERE cg_stat = 4 ORDER BY cg_shinsei_start,id";
		} elseif  ($stv == 6) {
			$sqlSelect = "SELECT * FROM changers WHERE cg_stat = 5 ORDER BY id DESC LIMIT 20";
		} elseif  ($stv == 7) {
			$sqlSelect = "SELECT * FROM changers WHERE cg_stat >= 1 AND cg_stat <= 5 ORDER BY id";
		} else {
			$sqlSelect = "SELECT * FROM changers";
		}

		// プリペアドステートメントインスタンスを取得。
		$stmt = $this->db->prepare($sqlSelect);

		// SQLの実行。
		$result = $stmt->execute();

		// SQL実行が成功した場合。
		if($result) {

			// フェッチループ。
			while($row = $stmt->fetch()) {

				// 各カラムデータの取得。
				$id = $row["id"];
				$cgStat = $row["cg_stat"];

				$cgIraiNo = $row["cg_irai_no"];
				$cgTantouName = $row["cg_tantou_name"];
				$cgKatasikiName = $row["cg_katasiki_name"];

				$cgNoukimaeDate = $row["cg_noukimae_date"];
				$cgNoukiatoDate = $row["cg_noukiato_date"];

				$cgHenkoCount = $row["cg_henko_count"];
				$cgRiyuu1No = $row["cg_riyuu1_no"];
				$cgRiyuu2No = $row["cg_riyuu2_no"];

				$cgOkureComent = $row["cg_okure_coment"];
				$cgKaesiComent = $row["cg_kaesi_coment"];

				$cgShinseiStart = $row["cg_shinsei_start"];
				$cgSyouninDate = $row["cg_syounin_date"];
				$cgSyoriDate = $row["cg_syori_date"];
				$cgCheckDate = $row["cg_check_date"];

				// Changerエンティティインスタンスを生成。
				$changer = new Changer();

				// Changerエンティティに各カラムデータを格納。
				$changer->setId($id);
				$changer->setCgStat($cgStat);

				$changer->setCgIraiNo($cgIraiNo);
				$changer->setCgTantouName($cgTantouName);
				$changer->setCgKatasikiName($cgKatasikiName);

				$changer->setCgNoukimaeDate($cgNoukimaeDate);
				$changer->setCgNoukiatoDate($cgNoukiatoDate);

				$changer->setCgHenkoCount($cgHenkoCount);
				$changer->setCgRiyuu1No($cgRiyuu1No);
				$changer->setCgRiyuu2No($cgRiyuu2No);

				$changer->setCgOkureComent($cgOkureComent);
				$changer->setCgKaesiComent($cgKaesiComent);

				$changer->setCgShinseiStart($cgShinseiStart);
				$changer->setCgSyouninDate($cgSyouninDate);
				$changer->setCgSyoriDate($cgSyoriDate);
				$changer->setCgCheckDate($cgCheckDate);

				// Changerエンティティを会員情報リスト連想配列に格納。
				$changerList[$id] = $changer;
			}
		}

		// 全件が格納された連想配列をリターン。
		return $changerList;
	}
//=========================================================================================================

	// 主キーによる検索メソッド。        <元状態>    <新状態>     <ID>  
	public function replChanger(int $cgSt, int $cgFl, int $cgId, Changer $changer): array
	{
		// 会員情報リストを格納する連想配列の用意。
		$changerList = [];

		// データ取得SQL文字列を用意。
		if       ($cgSt == 0)  {
			$sqlSelect = "UPDATE changers SET cg_stat = :cg_stat, cg_shinsei_start = :cg_shinsei_start, cg_kaesi_coment = :cg_kaesi_coment WHERE id = :id";
		} elseif (($cgSt == 1) or ($cgSt == 5) or ($cgSt == 6)) {
			$sqlSelect = "UPDATE changers SET cg_stat = :cg_stat WHERE id = :id";
		} elseif  ($cgSt == 2) {
			$sqlSelect = "UPDATE changers SET cg_stat = :cg_stat, cg_syounin_date = :cg_syounin_date, cg_kaesi_coment = :cg_kaesi_coment WHERE id = :id";
		} elseif  ($cgSt == 3) {
			$sqlSelect = "UPDATE changers SET cg_stat = :cg_stat, cg_syori_date = :cg_syori_date, cg_kaesi_coment = :cg_kaesi_coment WHERE id = :id";
		} elseif  ($cgSt == 4) {
			$sqlSelect = "UPDATE changers SET cg_stat = :cg_stat, cg_check_date = :cg_check_date, cg_kaesi_coment = :cg_kaesi_coment WHERE id = :id";
		} else {
			$changerList[$cgId] = -1;
			return $changerList;
		}

		// プリペアドステートメントインスタンスを取得。
		$stmt = $this->db->prepare($sqlSelect);

		// 変数をバインド。
		$stmt->bindValue(":id", $cgId, PDO::PARAM_INT);
		$stmt->bindValue(":cg_stat", $cgFl, PDO::PARAM_INT);
	
	if       ($cgSt == 0) {
		$stmt->bindValue(":cg_shinsei_start", date("Y-m-d"), PDO::PARAM_STR);
		$stmt->bindValue(":cg_kaesi_coment", $changer->getCgKaesiComent(), PDO::PARAM_STR);
	} elseif ($cgSt == 2) {
		$stmt->bindValue(":cg_syounin_date", date("Y-m-d"), PDO::PARAM_STR);
		$stmt->bindValue(":cg_kaesi_coment", $changer->getCgKaesiComent(), PDO::PARAM_STR);
	} elseif ($cgSt == 3) {
		$stmt->bindValue(":cg_syori_date", date("Y-m-d"), PDO::PARAM_STR);
		$stmt->bindValue(":cg_kaesi_coment", $changer->getCgKaesiComent(), PDO::PARAM_STR);
	} elseif ($cgSt == 4) {
		$stmt->bindValue(":cg_check_date", date("Y-m-d"), PDO::PARAM_STR);
		$stmt->bindValue(":cg_kaesi_coment", $changer->getCgKaesiComent(), PDO::PARAM_STR);
	}

		// SQLの実行。
		$result = $stmt->execute();

		// SQL実行が成功した場合。
		if($result) {

			// フェッチループ。
			while($row = $stmt->fetch()) {

				// 各カラムデータの取得。
				$id = $row["id"];
				$cgStat = $row["cg_stat"];

				$cgIraiNo = $row["cg_irai_no"];
				$cgTantouName = $row["cg_tantou_name"];
				$cgKatasikiName = $row["cg_katasiki_name"];

				$cgNoukimaeDate = $row["cg_noukimae_date"];
				$cgNoukiatoDate = $row["cg_noukiato_date"];

				$cgHenkoCount = $row["cg_henko_count"];
				$cgRiyuu1No = $row["cg_riyuu1_no"];
				$cgRiyuu2No = $row["cg_riyuu2_no"];

				$cgOkureComent = $row["cg_okure_coment"];
				$cgKaesiComent = $row["cg_kaesi_coment"];

				$cgShinseiStart = $row["cg_shinsei_start"];
				$cgSyouninDate = $row["cg_syounin_date"];
				$cgSyoriDate = $row["cg_syori_date"];
				$cgCheckDate = $row["cg_check_date"];

				// Changerエンティティインスタンスを生成。
				$changer = new Changer();

				// Changerエンティティに各カラムデータを格納。
				$changer->setId($id);
				$changer->setCgStat($cgStat);

				$changer->setCgIraiNo($cgIraiNo);
				$changer->setCgTantouName($cgTantouName);
				$changer->setCgKatasikiName($cgKatasikiName);

				$changer->setCgNoukimaeDate($cgNoukimaeDate);
				$changer->setCgNoukiatoDate($cgNoukiatoDate);

				$changer->setCgHenkoCount($cgHenkoCount);
				$changer->setCgRiyuu1No($cgRiyuu1No);
				$changer->setCgRiyuu2No($cgRiyuu2No);

				$changer->setCgOkureComent($cgOkureComent);
				$changer->setCgKaesiComent($cgKaesiComent);

				$changer->setCgShinseiStart($cgShinseiStart);
				$changer->setCgSyouninDate($cgSyouninDate);
				$changer->setCgSyoriDate($cgSyoriDate);
				$changer->setCgCheckDate($cgCheckDate);

				// Changerエンティティを会員情報リスト連想配列に格納。
				$changerList[$id] = $changer;
			}
		}

		// 全件が格納された連想配列をリターン。
		return $changerList;
	}

//=========================================================================================================

	// 全件を連想配列で得るメソッド。
	public function findAll2Array(): array
	{
		// データ取得SQL文字列を用意。
		$sqlSelect = "SELECT * FROM changers";

		// プリペアドステートメントインスタンスを取得。
		$stmt = $this->db->prepare($sqlSelect);

		// SQLの実行。
		$result = $stmt->execute();

		// SQLの結果表の全データを連想配列形式で取得。
		$allList = $stmt->fetchAll();

		// 全データが格納された連想配列をリターン。
		return $allList;
	}

//=========================================================================================================

	// 主キーによる検索メソッド。
	public function findByPK(int $id): ?changer
	{
		// データ取得SQL文字列を用意。
		$sqlSelect = "SELECT * FROM changers WHERE id = :id";

		// プリペアドステートメントインスタンスを取得。
		$stmt = $this->db->prepare($sqlSelect);

		// 変数をバインド。
		$stmt->bindValue(":id", $id, PDO::PARAM_INT);

		// SQLの実行。
		$result = $stmt->execute();

		// データ取得。
		if($result && $row = $stmt->fetch()) {

			// 各カラムデータの取得。
			$id = $row["id"];
			$cgStat = $row["cg_stat"];

			$cgIraiNo = $row["cg_irai_no"];
			$cgTantouName = $row["cg_tantou_name"];
			$cgKatasikiName = $row["cg_katasiki_name"];

			$cgNoukimaeDate = $row["cg_noukimae_date"];
			$cgNoukiatoDate = $row["cg_noukiato_date"];

			$cgHenkoCount = $row["cg_henko_count"];
			$cgRiyuu1No = $row["cg_riyuu1_no"];
			$cgRiyuu2No = $row["cg_riyuu2_no"];

			$cgOkureComent = $row["cg_okure_coment"];
			$cgKaesiComent = $row["cg_kaesi_coment"];

			$cgShinseiStart = $row["cg_shinsei_start"];
			$cgSyouninDate = $row["cg_syounin_date"];
			$cgSyoriDate = $row["cg_syori_date"];
			$cgCheckDate = $row["cg_check_date"];

			// Changerエンティティインスタンスを生成。
			$changer = new Changer();

			// Changerエンティティに各カラムデータを格納。
			$changer->setId($id);
			$changer->setCgStat($cgStat);

			$changer->setCgIraiNo($cgIraiNo);
			$changer->setCgTantouName($cgTantouName);
			$changer->setCgKatasikiName($cgKatasikiName);

			$changer->setCgNoukimaeDate($cgNoukimaeDate);
			$changer->setCgNoukiatoDate($cgNoukiatoDate);

			$changer->setCgHenkoCount($cgHenkoCount);
			$changer->setCgRiyuu1No($cgRiyuu1No);
			$changer->setCgRiyuu2No($cgRiyuu2No);

			$changer->setCgOkureComent($cgOkureComent);
			$changer->setCgKaesiComent($cgKaesiComent);

			$changer->setCgShinseiStart($cgShinseiStart);
			$changer->setCgSyouninDate($cgSyouninDate);
			$changer->setCgSyoriDate($cgSyoriDate);
			$changer->setCgCheckDate($cgCheckDate);

		}

		// Changerエンティティインスタンスをリターン。
		return $changer;
	}

}
