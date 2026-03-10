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
function GeneratorRow(Row0, names){
	let classRow = "";
	let classTD = "";
	if (Row0 == true){
		classRow = "grid-tr-0";
		classTD = "grid-td_mo";
	} else {
		classRow = "grid-tr";
		classTD = "grid-td_mo";
	}

    let elemrow = document.createElement('div');
	elemrow.className = classRow;
	grid_MOOverduelist.append(elemrow);

	for (let c = 0; c < names.length; c++){
		elem0 = document.createElement('div');		  
		elem0.className = classTD;
		elemrow.append(elem0);

		elem1 = document.createElement('div');		  
		elem1.className = "item";
		elem1.innerHTML = names[c];
		elem0.append(elem1);
	}
}



function KeyMOOverdue_ClickOK(str, param){  
  	const arr = JSON.parse(str);
	for (let q = 0; q < arr.length; q++){
	    if ((arr[q][0][0] == "OK") && (arr[q][0][1] > 0)){
			if (q == 0){
				GeneratorRow(true, ["Персонал", "MO", "Кол-во в жизни", "Кол-во сделано"]);
			} else if (q == 1){
				GeneratorRow(true, ["Персонал", "MO", "Кол-во на работе", "Кол-во сделано"]);
			} else if (q == 2){
				GeneratorRow(true, ["Персонал", "MO", "Дата окончания", "Кол-во месяц"]);
			}	

    		for (let r = 1; r < arr[q].length; r++) {
				if (q < 2){
					GeneratorRow(false, [arr[q][r].UserNameS, arr[q][r].MOTName, arr[q][r].MOAV, arr[q][r].MODONE]);
				} else {
					if (arr[q][r].TTTT > 1000) {
						GeneratorRow(false, [arr[q][r].UserNameS, arr[q][r].MOTName, "-", "-"]);
					} else {
						GeneratorRow(false, [arr[q][r].UserNameS, arr[q][r].MOTName, arr[q][r].MODONE, arr[q][r].TTTT]);
					}	
				}
/*

		        let elemrow = document.createElement('div');
        		elemrow.className = "grid-tr";
//				elemrow.setAttribute("IDUser", arr[q][r].IDUser);
//				elemrow.setAttribute("IDMOType", arr[q][r].IDMOType);
		//		elemrow.onclick = row_user_click;
				grid_MOOverduelist.append(elemrow);

		        elem = document.createElement('div');		  
		        elem.className = 'grid-td_mo';
				
		        elem.innerHTML = arr[q][r].UserNameS;
		        elemrow.append(elem);

		        elem = document.createElement('div');		  
		        elem.className = 'grid-td_mo';
		        elem.innerHTML = arr[q][r].MOTName;
		        elemrow.append(elem);

		        elem = document.createElement('div');		  
		        elem.className = 'grid-td_mo';
		        elem.innerHTML = arr[q][r].MOAV;
		        elemrow.append(elem);

		        elem = document.createElement('div');		  
		        elem.className = 'grid-td_mo';
		        elem.innerHTML = arr[q][r].MODONE;
		        elemrow.append(elem);*/
			}
		}
	}
};

function FERR_Error(str, param){
	alert ('Ошибка')
	return;
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
