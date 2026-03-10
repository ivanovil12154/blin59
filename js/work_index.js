let win_MOOverduelist = document.querySelector("#win_MOOverduelist");
let grid_MOOverduelist = win_MOOverduelist.querySelector(".grid");



function KeyGoUserList(){
	let params = {VGIDUser: GIDUser, 
		         VGUserFIO: GUserFIO, 
				 VGLogin: GUserLogin,
				 VGSession: GSession};
    postToSameTab("work_user_sp.php", params);
};


function KeyMOOverdue_Click(){
	let LFormDate = new FormData;
		LFormDate.append('VID', GIDUser);
		LFormDate.append('VLogin', GUserLogin);
		LFormDate.append('VSession', GSession);
		LFormDate.append('VFunction', "MOOverdueList"); 
		LFormDate.append('VMethod', "GET");
    	SendData('../fphp/phpsql.php', LFormDate, KeyMOOverdue_ClickOK, 'MOType', FERR_Error);
};	

function KeyMOOverdue_ClickOK(str, param){

};


function FERR_Error(str, param){

};




function work_getuserlist1(){
	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
     
    SendData('../fphp/work/GetUserList.php', LFormDate, FunGUOK, '', FunGUError);
};	

function FunGUOK1(str, param){

    alert ('Удача - ' + str); 
/*

	const arr = JSON.parse(str);
	if (arr.res == "OK") {
      alert ('Удача - ' + arr.name); 
	  document.location.href = '../workfol/workindex.php';

	} else if (arr.res == "ErrorLogin") {
		alert ("Ошибка, логин или пароль не найдены");
	}
*/

/*
	if (str == 'LClose'){
		alert ('Логин занят')
		return;
	};

	if (str != 'OK'){
		alert ('Ошибка')
		return;
	};
    alert ('Удача')
	return;

	OnClickCloseWinPred();
	Llogin = param;
    */
}

function FunGUError1(str, param){
	alert ('Ошибка')
	return;
};

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

/*
	if (str == 'LClose'){
		alert ('Логин занят')
		return;
	};

	if (str != 'OK'){
		alert ('Ошибка')
		return;
	};
    alert ('Удача')
	return;

	OnClickCloseWinPred();
	Llogin = param;
    */


function FunNLError1(str, param){
	alert ('Ошибка')
	return;
};
