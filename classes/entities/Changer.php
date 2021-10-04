<?php
namespace SocymSlim\MVC\entities;

class Changer
{
	private $id;
	private $cgStat;

	private $cgIraiNo;
	private $cgTantouName;
	private $cgKatasikiName;

	private $cgNoukimaeDate;
	private $cgNoukiatoDate;

	private $cgHenkoCount;
	private $cgRiyuu1No;
	private $cgRiyuu2No;

	private $cgOkureComent;
	private $cgKaesiComent;

	private $cgShinseiStart;
	private $cgSyouninDate;
	private $cgSyoriDate;
	private $cgCheckDate;


////////////////////////////////////////////////
// エンティティのゲッタとセッタの定義。
////////////////////////////////////////////////


	// ID（シリアル番号）のゲッタとセッタ
	public function getId(): ?int
	{
		return $this->id;
	}
	public function setId(?int $id): void
	{
		$this->id = $id;
	}


	// フラグ（有効/無効）のゲッタとセッタ
	public function getCgStat(): ?int
	{
		return $this->cgStat ;
	}
	public function setCgStat(?int $cgStat): void
	{
		$this->cgStat = $cgStat;
	}


	// 修理依頼番号（５桁と [ Y か S ] ）のゲッタとセッタ
	public function getCgIraiNo(): ?string
	{
		return $this->cgIraiNo;
	}
	public function setCgIraiNo(?string $cgIraiNo): void
	{
		$this->cgIraiNo = $cgIraiNo;
	}

	
	// 担当者（名前）のゲッタとセッタ
	public function getCgTantouName(): ?string
	{
		return $this->cgTantouName;
	}
	public function setCgTantouName(?string $cgTantouName): void
	{
		$this->cgTantouName = $cgTantouName;
	}


	// 型式（製品の名前）のゲッタとセッタ
	public function getCgKatasikiName(): ?string
	{
		return $this->cgKatasikiName;
	}
	public function setCgKatasikiName(?string $cgKatasikiName): void
	{
		$this->cgKatasikiName = $cgKatasikiName;
	}


	// 納期変更前（変更前の日付）のゲッタとセッタ
	public function getCgNoukimaeDate(): ?string
	{
		return $this->cgNoukimaeDate;
	}
	public function setCgNoukimaeDate(?string $cgNoukimaeDate): void
	{
		$this->cgNoukimaeDate = $cgNoukimaeDate;
	}


	// 納期変更後（変更後の日付）のゲッタとセッタ
	public function getCgNoukiatoDate(): ?string
	{
		return $this->cgNoukiatoDate;
	}
	public function setCgNoukiatoDate(?string $cgNoukiatoDate): void
	{
		$this->cgNoukiatoDate = $cgNoukiatoDate;
	}


	// 変更回数（変更した回数）のゲッタとセッタ
	public function getCgHenkoCount(): ?int
	{
		return $this->cgHenkoCount;
	}
	public function setCgHenkoCount(?int $cgHenkoCount): void
	{
		$this->cgHenkoCount = $cgHenkoCount;
	}


	// 納期変更1の理由（納期変更1の原因）のゲッタとセッタ
	public function getCgRiyuu1No(): ?string
	{
		return $this->cgRiyuu1No;
	}
	public function setCgRiyuu1No(?string $cgRiyuu1No): void
	{
		$this->cgRiyuu1No = $cgRiyuu1No;
	}


	// 納期変更2の理由（納期変更2の原因）のゲッタとセッタ
	public function getCgRiyuu2No(): ?string
	{
		return $this->cgRiyuu2No;
	}
	public function setCgRiyuu2No(?string $cgRiyuu2No): void
	{
		$this->cgRiyuu2No = $cgRiyuu2No;
	}


	// 納期変更の理由（遅れの理由）のゲッタとセッタ
	public function getCgOkureComent(): ?string
	{
		return $this->cgOkureComent;
	}
	public function setCgOkureComent(?string $cgOkureComent): void
	{
		$this->cgOkureComent = $cgOkureComent;
	}


	// 納期変更の返し（戻す時のコメント）のゲッタとセッタ
	public function getCgKaesiComent(): ?string
	{
		return $this->cgKaesiComent;
	}
	public function setCgKaesiComent(?string $cgKaesiComent): void
	{
		$this->cgKaesiComent = $cgKaesiComent;
	}


	// 納期変更の申請日（担当者の申請日）のゲッタとセッタ
	public function getCgShinseiStart(): ?string
	{
		return $this->cgShinseiStart;
	}
	public function setCgShinseiStart(?string $cgShinseiStart): void
	{
		$this->cgShinseiStart = $cgShinseiStart;
	}


	// 納期変更の承認日（承認者の承認日）のゲッタとセッタ
	public function getCgSyouninDate(): ?string
	{
		return $this->cgSyouninDate;
	}
	public function setCgSyouninDate(?string $cgSyouninDate): void
	{
		$this->cgSyouninDate = $cgSyouninDate;
	}


	// 納期変更の処理日（処理者の処理日）のゲッタとセッタ
	public function getCgSyoriDate(): ?string
	{
		return $this->cgSyoriDate;
	}
	public function setCgSyoriDate(?string $cgSyoriDate): void
	{
		$this->cgSyoriDate = $cgSyoriDate;
	}


	// 納期変更の確認日（確認者の確認日）のゲッタとセッタ
	public function getCgCheckDate(): ?string
	{
		return $this->cgCheckDate;
	}
	public function setCgCheckDate(?string $cgCheckDate): void
	{
		$this->cgCheckDate = $cgCheckDate;
	}

}
