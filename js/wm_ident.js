function WM_IdentonKeySend(){
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

	let LFormDate = new FormData;
	LFormDate.append('VLogin', TextLogin);
	LFormDate.append('VPassword', TextPassword);
     
  SendData('fphp/ident/GetIdent.php', LFormDate, FunNLOK, TextLogin, FunNLError);
};

function FunNLOK(str, param){

    alert (str);
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
