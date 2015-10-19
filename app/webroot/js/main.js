// JS Document
function UpdateDetails(ex){
	var delay = 10000;
	var now, before = new Date();
	GetDetails(ex,delay/1000);
	setInterval(function() {
    now = new Date();
    var elapsedTime = (now.getTime() - before.getTime());
    GetDetails(ex,delay/1000);
    before = new Date();    
}, delay);
	
}
function GetDetails(ex,counter){
	var refreshID = setInterval(function() {
		counter = counter - 1;
		$("#Timer").html(counter);
		if(counter <= 0){
			clearInterval(refreshID);
			return;
			}
	}	,1000);	
	user_id = $("#User_ID").html();
	if(ex=="/EX/DASHBOARD"){ex = "BTC/GBP";}
	CheckServer();
	$.getJSON('/Updates/Rates/'+ex,
		function(ReturnValues){
			if(ReturnValues['Refresh']=="Yes"){
					$.getJSON('/Updates/Orders/'+ex,
						function(Orders){
							$('#BuyOrders').html(Orders['BuyOrdersHTML']);
							$('#SellOrders').html(Orders['SellOrdersHTML']);							
					});
					$.getJSON('/Updates/YourOrders/'+ex+'/'+user_id,
						function(Orders){
							$('#YourCompleteOrders').html(Orders['YourCompleteOrdersHTML']);
							$('#YourOrders').html(Orders['YourOrdersHTML']);							
					});
			}
			
			$("#LowPrice").html(ReturnValues['Low']);
			$("#HighPrice").html(ReturnValues['High']);					
			$("#LowestAskPrice").html(ReturnValues['High']);	
			if($("#BuyPriceper").val()=="" || $("#BuyPriceper").val()==0){
				$("#BuyPriceper").val(ReturnValues['High']);
			}
			$("#HighestBidPrice").html(ReturnValues['Low']);
			if($("#SellPriceper").val()=="" || $("#SellPriceper").val()==0){
				$("#SellPriceper").val(ReturnValues['Low']);
			}
			$("#LastPrice").html(ReturnValues['Last']);
			Volume = ReturnValues['VolumeFirst'] + " " + ReturnValues['VolumeFirstUnit'] +
			" / " + ReturnValues['VolumeSecond'] + " " + ReturnValues['VolumeSecondUnit'];
			$("#Volume").html(Volume);					
		});
}
function CheckServer(){
		$.getJSON('/Updates/CheckServer/',
		function(ReturnValues){
			if(ReturnValues['Refresh']=="No"){
				window.location.assign("/login");								
			}
		});
}

function BuyFormCalculate (){
	Multiple = $('#BuyMultiple').val();
	if(Multiple=="Y"){
		if(!confirm("Do you want to execute Multiple orders?")){
			return;
		}
	}
	BalanceSecond = $('#BalanceSecond').html();
	FirstCurrency = $('#BuyFirstCurrency').val();
	SecondCurrency = $('#BuySecondCurrency').val();
	BuyAmount = $('#BuyAmount').val();
	BuyPriceper = $('#BuyPriceper').val();
	if(BuyAmount=="" || BuyAmount<=0){
			$("#BuySummary").html("Amount less than Zero!");
			$("#BuySubmitButton").attr("disabled", "disabled");
			$("#BuySubmitButton").attr("class", "btn btn-warning btn-block");
		return false;
	}
	if(BuyAmount>999999){
			$("#BuySummary").html("Amount greater than 1000000!");
			$("#BuySubmitButton").attr("disabled", "disabled");
			$("#BuySubmitButton").attr("class", "btn btn-warning btn-block");
		return false;
	}
	if(BuyPriceper=="" || BuyPriceper<=0){
		$("#BuySummary").html("Price less than Zero!");
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning btn-block");
		return false;
	}
	if(BuyPriceper>999999){
		$("#BuySummary").html("Price greater than 1000000!");
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning btn-block");
		return false;
	}

	TotalValue = BuyAmount * BuyPriceper;
	TotalValue = TotalValue.toFixed(6);
	$("#BuyTotal").html(TotalValue);
	
	$.getJSON('/Updates/Commission/',
		function(ReturnValues){
			$("#BuyCommission").val(ReturnValues['Commission']);			
			Commission = $('#BuyCommission').val();
			Fees = BuyAmount * Commission / 100;
			Fees = Fees.toFixed(5);
			if(Fees<=0){return false;}
			$("#BuyFee").html(Fees);	
			$('#BuyCommissionAmount').val(Fees);
			$('#BuyCommissionCurrency').val(FirstCurrency);			
		}
	);
	GrandTotal = TotalValue;
	if(GrandTotal==0){
		BuySummary = "Amount cannot be Zero";
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning btn-block");
		return false;
	}
	if(parseFloat(BalanceSecond) <= parseFloat(GrandTotal)){
		Excess = parseFloat(GrandTotal) - parseFloat(BalanceSecond);
		Excess = Excess.toFixed(5)		
		BuySummary = "The transaction amount exceeds the balance by " + Excess + " " + SecondCurrency;
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning btn-block");
	}else{
		BuySummary = "The transaction amount " + GrandTotal  + " " + SecondCurrency;
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").removeAttr('disabled');
		$("#BuySubmitButton").attr("class", "btn btn-success btn-block");		
	}
	if(parseFloat(GrandTotal)===0){$("#BuySubmitButton").attr("disabled", "disabled");}
}
function SellFormCalculate (){
	Multiple = $('#SellMultiple').val();
	if(Multiple=="Y"){
		if(!confirm("Do you want to execute Multiple orders?")){
			return;
		}
	}
	
	BalanceFirst = $('#BalanceFirst').html();
	FirstCurrency = $('#SellFirstCurrency').val();
	SecondCurrency = $('#SellSecondCurrency').val();
	SellAmount = $('#SellAmount').val();
	SellPriceper = $('#SellPriceper').val();
	if(SellAmount=="" || SellAmount<=0){
		$("#SellSummary").html("Amount less than Zero!");
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning btn-block");		
		return false;
	}
	if(SellAmount>999999){
		$("#SellSummary").html("Amount greater than 1000000!");
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning btn-block");		
		return false;
	}
	if(SellPriceper=="" || SellPriceper<=0){
		$("#SellSummary").html("Price less than Zero!");
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning btn-block");		
		return false;
	}
	if(SellPriceper>999999){
		$("#SellSummary").html("Price greater than 1000000!");
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning btn-block");		
		return false;
	}

	TotalValue = SellAmount * SellPriceper;
	TotalValue = TotalValue.toFixed(6);
	$("#SellTotal").html(TotalValue);
	
	$.getJSON('/Updates/Commission/',
		function(ReturnValues){
			$("#SellCommission").val(ReturnValues['Commission']);			
			Commission = $('#SellCommission').val();;	
			Fees = TotalValue * Commission / 100;
			if(Fees<=0){return false;}
			Fees = Fees.toFixed(5);
			$("#SellFee").html(Fees);	
			$('#SellCommissionAmount').val(Fees);
			$('#SellCommissionCurrency').val(SecondCurrency);						
		}
	);

	GrandTotal = SellAmount;
	if(SellAmount==0){
	SellSummary = "Amount cannot be Zero";
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning btn-block");		
		return false;
	}

	if(parseFloat(BalanceFirst) < parseFloat(GrandTotal)){
		Excess =  parseFloat(GrandTotal) - parseFloat(BalanceFirst)  ;
		Excess = Excess.toFixed(5)
		SellSummary = "The transaction amount exceeds the balance by " + Excess + " " + FirstCurrency;
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning btn-block");				
	}else{
		SellSummary = "The transaction amount " + GrandTotal  + " " + FirstCurrency;
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").removeAttr('disabled');
		$("#SellSubmitButton").attr("class", "btn btn-success btn-block");				
	}
	if(parseFloat(GrandTotal)===0){$("#SellSubmitButton").attr("disabled", "disabled");}
}
function SellOrderFill(SellOrderPrice,SellOrderAmount,IDs){
	
	$("#BuyMultiple").val("Y");
	$("#BuyIDs").val(IDs);
	$("#BuyAmount").val(SellOrderAmount)  ;
	$("#BuyPriceper").val(SellOrderPrice)  ;
	$("#BuySubmitButton").attr("disabled", "disabled");	
	$("#BuySubmitButton").attr("class", "btn btn-warning btn-block");				
}
function BuyOrderFill(BuyOrderPrice,BuyOrderAmount,IDs){
	
	$("#SellMultiple").val("Y");
	$("#SellIDs").val(IDs);
	$("#SellAmount").val(BuyOrderAmount)  ;
	$("#SellPriceper").val(BuyOrderPrice)  ;
	$("#SellSubmitButton").attr("disabled", "disabled");	
	$("#SellSubmitButton").attr("class", "btn btn-warning btn-block");					
}
function ConvertBalance(){
	BTCRate = $("#BTCRate").val();
	LTCRate = $("#LTCRate").val();	
	USDRate = $("#USDRate").val();	
	GBPRate = $("#GBPRate").val();	
	EURRate = $("#EURRate").val();	
	Currency = $("#Currency" ).val();		
	switch(Currency){
		case "BTC":
		  break;
		case "LTC":
		  break;
		case "USD":
		  break;
		case "EUR":
		  break;
		case "GBP":
		  break;
	}
	
}
function SendPassword(){
	$.getJSON('/Users/SendPassword/'+$("#Username").val(),
		function(ReturnValues){
			if(ReturnValues['Password']=="Password Not sent"){
				$("#UserNameIcon").attr("class", "fa fa-remove");
				$("#LoginEmailPassword").hide();
				return false;
			}
			$("#LoginEmailPassword").show();
			$("#LoginButton").removeAttr('disabled');			
			$("#UserNameIcon").attr("class", "fa fa-check");
			
			if(ReturnValues['TOTP']=="Yes"){
				$("#TOTPPassword").show();
			}else{
				$("#TOTPPassword").hide();
			}
//			if(ReturnValues['EmailPasswordSecurity']=="true"){
//				$("#LoginEmailPassword").show();
//			}else{
//				$("#LoginEmailPassword").hide();
//			}
			
		}
	);
}

function SaveTOTP(){
	if($("#ScannedCode").val()==""){return false;}
	$.getJSON('/Users/SaveTOTP/',{
			  Login:$("#Login").is(':checked'),
			  Withdrawal:$("#Withdrawal").is(':checked'),			  
			  Security:$("#Security").is(':checked'),
			  ScannedCode:$("#ScannedCode").val()
			  },
		function(ReturnValues){
			if(ReturnValues){
				window.location.assign("/users/settings");				
			}			
		}
	);
}
function CheckTOTP(){
	if($("#CheckCode").val()==""){return false;}
	$.getJSON('/Users/CheckTOTP/',{
			  CheckCode:$("#CheckCode").val()
			  },
		function(ReturnValues){
			if(ReturnValues){
				window.location.assign("/users/settings");		
			}
		}
	);
}


function DeleteTOTP(){
	$.getJSON('/Users/DeleteTOTP/',
		function(ReturnValues){}
	);	
}
function CheckDeposit(){
	AmountFiat = $("#AmountFiat").val();
	if(AmountFiat==""){return false;}
	}
function CheckWithdrawal(){
	if($("#WithdrawalMethod").val()=="bank"){
		AccountName = $("#AccountName").val();		
		if(AccountName==""){return false;}
		SortCode = $("#SortCode").val();
		if(SortCode==""){return false;}
		AccountNumber = $("#AccountNumber").val();
		if(AccountNumber==""){return false;}
	}
	if($("#WithdrawalMethod").val()=="bankBuss"){
		AccountName = $("#AccountName").val();		
		if(AccountName==""){return false;}
		SortCode = $("#SortCode").val();
		if(SortCode==""){return false;}
		AccountNumber = $("#AccountNumber").val();
		if(AccountNumber==""){return false;}
		CompanyName = $("#CompanyName").val();
		if(CompanyName==""){return false;}
		CompanyNumber = $("#CompanyNumber").val();
		if(CompanyNumber==""){return false;}
	}	
	if($("#WithdrawalMethod").val()=="post"){
		PostalName = $("#PostalName").val();
		if(PostalName==""){return false;}		
		PostalStreet = $("#PostalStreet").val();
		if(PostalStreet==""){return false;}		
		PostalAddress = $("#PostalAddress").val();
		if(PostalAddress==""){return false;}		
		PostalCity = $("#PostalCity").val();
		if(PostalCity==""){return false;}		
		PostalZip = $("#PostalZip").val();
		if(PostalZip==""){return false;}		
		PostalCountry = $("#PostalCountry").val();
		if(PostalCountry==""){return false;}		
	}
	WithdrawAmountFiat = $("#WithdrawAmountFiat").val();
	if(WithdrawAmountFiat==""){alert("Amount not entered");return false;}
	if(parseInt(WithdrawAmountFiat)<=5 && $("#WithdrawalMethod").val()!='okpay'){alert("Amount less than 5");return false;}
	if(parseInt(WithdrawAmountFiat)<1 && $("#WithdrawalMethod").val()=='okpay'){alert("Amount less than 1");return false;}	
}

function RejectReason(value){
	url = $("#RejectURL").attr('href');
	len = url.length-2;
	nurl = url.substr(0,len)+value;
	$("#RejectURL").attr('href',nurl);
}
function currencyAddress(currency){
	address = $("#currencyaddress").val();
  $("#Send"+currency+"Address").html(address); 	
	SuccessButtonDisable();
	}
function SuccessButtonDisable(){
	$("#SendSuccessButton").attr("disabled", "disabled");
}
function CheckCurrencyPayment(currency){
	address = $("#currencyaddress").val();
	$("#AmountError").hide();
	if(address==""){return false;}
	amount = $("#Amount").val();
	if(parseFloat(amount)<=0){
		$("#AmountError").show();
		return false;
	}else{
	$("#AmountError").hide();
	}
	if(amount==""){return false;}
	maxValue = $("#maxValue").val();
	if(parseFloat(amount)==0){
		$("#AmountError").show();
		return false;}
	if(parseFloat(amount)>parseFloat(maxValue)){
		$("#AmountError").show();
		return false;
	}
	
	$("#Send"+currency+"Fees").html($("#txFee").val());

	$("#Send"+currency+"Amount").html(amount);	
	$("#Send"+currency+"Total").html(parseFloat(amount)-parseFloat($("#txFee").val()));	
	$("#TransferAmount").val(parseFloat(amount)-parseFloat($("#txFee").val()));

	$.getJSON('/Updates/CurrencyAddress/'+currency+'/'+address,
		function(ReturnValues){
			if(ReturnValues['verify']['isvalid']==true){
				switch(ReturnValues['currency'])
					{
					case "BTC":
					address = "<a href='http://blockchain.info/address/"+ address +"' target='_blank'>"+ address +"</a> <i class='fa fa-ok'></i>";
						break;
					case "XGC":
					address = "<a href='http://greencoin.io/blockchain/address/"+ address +"' target='_blank'>"+ address +"</a> <i class='fa fa-ok'></i>";

						break;
					case "LTC":
					address = "<a href='http://ltc.block-explorer.com/address/"+ address +"' target='_blank'>"+ address +"</a> <i class='fa fa-ok'></i>";
						break;
					default:
					address = address +" <i class='fa fa-remove'></i>";					
					} 
					$("#Send"+currency+"SuccessButton").removeAttr('disabled');							
				}else{
						address = address +" <i class='fa fa-remove'></i>";					
				}
			$("#Send"+currency+"Address").html(address); 	
});
	return true;
	}
function PaymentMethod(value){
	if(value=="bank"){
		$("#WithdrawalBank").show();
		$("#WithdrawalBankBuss").hide();		
		$("#WithdrawalPost").hide();
		$("#WithdrawalOkPay").hide();		
	}
	if(value=="post"){
		$("#WithdrawalBank").hide();
		$("#WithdrawalBankBuss").hide();				
		$("#WithdrawalPost").show();
		$("#WithdrawalOkPay").hide();				
	}
	if(value=="bankBuss"){
		$("#WithdrawalBank").hide();
		$("#WithdrawalBankBuss").show();				
		$("#WithdrawalPost").hide();
		$("#WithdrawalOkPay").hide();				
	}
	if(value=="okpay"){
		$("#WithdrawalBank").hide();
		$("#WithdrawalBankBuss").hide();				
		$("#WithdrawalPost").hide();
		$("#WithdrawalOkPay").show();				
	}
}
function DepositByMethod(value){
	if(value=="okpay"){
		$("#DepositPost").hide();
		$("#DepositOkPay").show();		
		$("#MailSelect").hide();
		$("#OkPaySelect").show();		
	}
	if(value=="post"){
		$("#DepositPost").show();
		$("#DepositOkPay").hide();		
		$("#MailSelect").show();
		$("#OkPaySelect").hide();		
	}
}
function AutoFillBuy(){
	$("#BuyAmount").val($("#BalanceSecond").html());
}
function AutoFillSell(){
	$("#SellAmount").val($("#BalanceFirst").html());
}
function CheckFirstName(value){
	if(value.length>=2){
		$("#FirstNameIcon").attr("class", "fa fa-check");	
	}else{
		$("#FirstNameIcon").attr("class", "fa fa-remove");			
	}
}
function CheckLastName(value){
	if(value.length>=2){
		$("#LastNameIcon").attr("class", "fa fa-check");	
	}else{
		$("#LastNameIcon").attr("class", "fa fa-remove");			
	}
}
function CheckUserName(value){
	if(value.length>=6){
		$.getJSON('/ex/username/'+value,
		function(ReturnValues){
			if(ReturnValues['Available']=='Yes'){
				$("#UserNameIcon").attr("class", "fa fa-check");	
			}else{
				$("#UserNameIcon").attr("class", "fa fa-remove");							
			}
		});
	}else{
		$("#UserNameIcon").attr("class", "fa fa-asterisk");			
	}
}
function CheckPassword(value){
	if(value.length>=10){
		if($("#Password").val()==$("#Password2").val()){
			$("#PasswordIcon").attr("class", "fa fa-check");			
			$("#Password2Icon").attr("class", "fa fa-check");
		}else{
			$("#PasswordIcon").attr("class", "fa fa-remove");					
			$("#Password2Icon").attr("class", "fa fa-remove");							
			return;
		}
	}else{
		$("#PasswordIcon").attr("class", "fa fa-asterisk");					
		$("#Password2Icon").attr("class", "fa fa-asterisk");							
		return;
	}
}
function CheckEmail(email){
	email = email.toLowerCase();
	$("#Email").val(email);	
	if(validateEmail(email)){
		$.getJSON('/ex/signupemail/'+email,
			function(ReturnValues){
			if(ReturnValues['Available']=='Yes'){
				$("#EmailIcon").attr("class", "fa fa-check");					
			}else{
				$("#EmailIcon").attr("class", "fa fa-remove");
			}
		});							
	}else{
		$("#EmailIcon").attr("class", "fa fa-asterisk");						
	}
}

function registerUser(){
	var walletid = guid();
	var xemail = '';
	var xwalletid = '';
	var recordid = '';
	if($("#FirstNameIcon").attr("class")!='fa fa-check'){return false;}
	if($("#LastNameIcon").attr("class")!='fa fa-check'){return false;}
	if($("#UserNameIcon").attr("class")!='fa fa-check'){return false;}
	if($("#EmailIcon").attr("class")!='fa fa-check'){return false;}
	if($("#PasswordIcon").attr("class")!='fa fa-check'){return false;}

	$.getJSON('/ex/register/',{
				FirstName:$("#Firstname").val(),
				LastName:$("#Lastname").val(),
				UserName:$("#Username").val(),
				Email:$("#Email").val(),
				Password:$("#Password").val(),
				Walletid:walletid,
			}, function(ReturnValues){
//				alert(ReturnValues['success']);
//				alert(ReturnValues['xemail']);
//				alert(ReturnValues['xwalletid']);
//				alert(ReturnValues['recordid']);
					if(ReturnValues['success']==1){
						xemail = ReturnValues['xemail'];
						xwalletid = ReturnValues['xwalletid'];
						recordid = ReturnValues['recordid'];
						var email = $("#Email").val();
						var password = $("#Password").val();
						var username = $("#Username").val();
						var keys = createKeys(recordid,xemail,xwalletid,email,walletid,username);
						var address0 = keys.pubkey.toString();	
						var privkey0 = keys.privkey.toString();
						var pubkeycompress0 = keys.pubkeycompress.toString();		
					//	alert(address);
					//	alert(privkey);
					//	alert(pubkeycompress0);

						email = ReturnValues['main_email'];
						xemail = ReturnValues['xmain_email'];
						var keys = createKeys(recordid,xemail,xwalletid,email,walletid,username);
						var address1 = keys.pubkey.toString();	
						var privkey1 = keys.privkey.toString();
						var pubkeycompress1 = keys.pubkeycompress.toString();		
					//	alert(address);
					//	alert(privkey);
					//	alert(pubkeycompress1);

						email = ReturnValues['escrow_email'];
						xemail = ReturnValues['xescrow_email'];
						var keys = createKeys(recordid,xemail,xwalletid,email,walletid,username);
						var address2 = keys.pubkey.toString();	
						var privkey2 = keys.privkey.toString();
						var pubkeycompress2 = keys.pubkeycompress.toString();		
					//	alert(address);
					//	alert(privkey);
					//	alert(pubkeycompress2);
				
					$.getJSON('/ex/updateaddress/',{
						recordid:recordid,
						pk0:pubkeycompress0,
						pk1:pubkeycompress1,
						pk2:pubkeycompress2,
					 walletid:walletid,
					},function(rv){
							if(rv['success']==1){
								window.location.assign("/users/email");
//								alert("Done");
							}
					});	
				}
			});
	return false;
}

	function EmailPasswordSecurity(value){
		$.getJSON('/Users/EmailPasswordSecurity/'+value,
		function(ReturnValues){});
	}
////////////////////////Common Functions////////////////////////////////////////////////
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 
function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}
function createKeys(recordid,xemail,xwalletid,email,walletid,username){
//	alert("record: "+record);
//	alert("recordid: "+recordid);
//	alert("xemail: "+xemail);
//	alert("xwalletid: "+xwalletid);
//	alert("email: "+email);
//	alert("walletid: "+walletid);
//	alert("username: "+username);
//	alert("password: "+password);

		var keys = btc.keys(
			Crypto.SHA256(
				recordid + email + xemail + walletid + xwalletid + username + 
				Crypto.SHA256(
					recordid + email + xemail + walletid + xwalletid + username + 
					Crypto.SHA256(
						recordid + email + xemail + walletid + xwalletid + username 
					)
				)
			)
		);
		//var greencoinAddress = keys.pubkey.toString();	
		//var privkey = keys.privkey.toString();
		//var pubkeycompress = keys.pubkeycompress.toString();		
		return keys;
}
