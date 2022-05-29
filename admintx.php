<?
	//https://github.com/perilouswithadollarsign/cstrike15_src/blob/f82112a2388b841d72cb62ca48ab1846dfcc11c8/common/imageutils.cpp#L845
	$id = $_GET["id"];
	$qq = $_GET["qq"];
	if($id == null || $qq == null)
		return;
	require_once("SteamID.php");
	$s = new SteamID($id);
	if( $s->GetAccountType() !== SteamID :: TypeIndividual  || !$s->IsValid())
	{
		throw new InvalidArgumentException( '无效的链接或steamid.' );
	}

	$s->SetAccountInstance( SteamID :: DesktopInstance );
	$s->SetAccountUniverse( SteamID :: UniversePublic );
	$id64 = $s-> ConvertToUInt64(); 
	imagepng(resize(imagecreatefromjpeg("https://q2.qlogo.cn/headimg_dl?dst_uin=$qq&spec=100")),"avatar/$qq.png");
	exec("convert -size 64x64 $qq.png -depth 8 avatar/$id64.rgb");
	unlink("avatar/$qq.png");

	function resize($img, $newx = 64,$newy = 64)
	{
		$x = imagesx($img);
		$y = imagesy($img);
		$im2 = imagecreatetruecolor($newx, $newy);
		imagecopyresized($im2, $img, 0, 0, 0, 0, $newx, $newy, $x, $y);
		return $im2;
	}
    