
let win_user_list = document.querySelector("#user_list");
let win_user_edit = document.querySelector("#user_edit");

win_user_list.classList.remove('delete');
win_user_edit.classList.add('delete');

work_getuserlist();


//////////////////////////////////////////////////////////////////////////
function work_useredit(){
    win_user_list.classList.add('delete');
    win_user_edit.classList.remove('delete');
};

//////////////////////////////////////////////////////////////////////////
function work_getuserlist(){
//    alert ('запуск - '); 

//   win_user_list.classList.add('delete');
//   win_user_edit.classList.remove('delete');


	let LFormDate = new FormData;
	LFormDate.append('VID', LIDUser);
     
    SendData('../fphp/work/GetUserList.php', LFormDate, FOK_GetUserList, '', FERR_GetUserList);
};	

function FOK_GetUserList(str, param){
  	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
    alert ('Удача, кол-во записей - ' + arr[0][1]);     

    let cr = arr.length;
    if (cr > 1){
      for (let r = 1; r < arr.length; r++) {
        let rr = arr[r].length;  
        for (let c = 1; c < arr[r].length; c++ ) {
          let elem = document.createElement('div');
          elem.className = 'grid_row';
          elem.innerHTML = arr[r][c];
          let divspis =  document.querySelector("#grid_user_list");
          divspis.append(elem);
        };  
      };
    };
    
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

function FERR_GetUserList(str, param){
	alert ('Ошибка')
	return;
};

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function work_getmslist(){
//   alert ('Введите логин');
   

/*

  let ElemLogin = WMIdent.querySelector('#WMIKS_LoginText');
  let ElemPassword = WMIdent.querySelector('#WMIKS_PasswordText');

  let TextLogin = ElemLogin.value.trim();
  let TextPassword = ElemPassword.value.trim();

//  TextLogin = 'Login';  
//   TextPassword = 'Password';

  if (TextLogin == ''){
    alert ('Введите логин');
    return;
  };
  if (TextPassword == ''){
		alert('Введите пароль');
		return;
	};
    */

	let LFormDate = new FormData;
	LFormDate.append('VID', LIDUser);
     
  SendData('../fphp/work/GetMsList.php', LFormDate, FunNLOK, '', FunNLError);
};

function FunNLOK(str, param){

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

function FunNLError(str, param){
	alert ('Ошибка')
	return;
};
