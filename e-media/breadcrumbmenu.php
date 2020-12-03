<?
switch ($method) {
	// user management
	case "usermgmt" :
		echo "<li class='breadcrumb-item'>Home</li>
		<li class='breadcrumb-item'><a href='#'>Data Pengguna</a></li>
		<li class='breadcrumb-item active'><a class='current' href='#'>Pengguna</a></li>";
		break;
	case "mstrmedia" :
		echo "<li class='breadcrumb-item'>Home</li>
		<li class='breadcrumb-item'><a href='#'>Data Master</a></li>
		<li class='breadcrumb-item active'><a href='#'>Data Media</a></li>";
		break;
	case "mstrproduct" :
		echo "<li class='breadcrumb-item'>Home</li>
		<li class='breadcrumb-item'><a href='#'>Data Master</a></li>
		<li class='breadcrumb-item active'><a href='#'>Data Produk</a></li>";
		break;
    case "txpositivenews" :
		echo "<li class='breadcrumb-item'>Home</li>
		<li class='breadcrumb-item'><a href='#'>Data Rating</a></li>
		<li class='breadcrumb-item active'><a href='#'>Berita Positif</a></li>";
        break;
	case "txnegativenews" :
		echo "<li class='breadcrumb-item'>Home</li>
		<li class='breadcrumb-item'><a href='#'>Data Rating</a></li>
		<li class='breadcrumb-item active'><a href='#'>Berita Negatif</a></li>";
		break;
	case "txadvertorialnews" :
		echo "<li class='breadcrumb-item'>Home</li>
		<li class='breadcrumb-item'><a href='#'>Data Rating</a></li>
		<li class='breadcrumb-item active'><a href='#'>Berita Advertorial</a></li>";
		break;
	case "mstrparameterlevel1" :
		echo "<li class='breadcrumb-item'>Home</li>
		<li class='breadcrumb-item'><a href='#'>Data Master</a></li>
		<li class='breadcrumb-item active'><a href='#'>Global Parameter</a></li>";
		break;

	default :
		echo "<li class='breadcrumb-item'>Home</li>
		<li class='breadcrumb-item active'><a class='current' href='#'>Dasbor</a></li>";
		break;
}
?>
