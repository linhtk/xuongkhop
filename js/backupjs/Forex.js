function ShowForexRate()
{
	function AddCurrencyRate(Currency, Rate)
	{
		document.writeln('<tr bgcolor="#ffffff"><td class=BoxItem>&nbsp;', Currency, '</td><td class=BoxItem align=right>', Rate, '&nbsp;</td></tr>');
	}
	if (!AddForexHeader('Forex', 'T&#7927; gi&#225;', 3, PageHost.concat('/images/i_Stock.gif')))
		return;
		
	function AddCurrencyRate_Header(Currency, Rate)
	{
		document.writeln('<tr bgcolor="#0167a9" style="height:20px;"><td style="color:#fff;font-weight:bold;font-size:8pt;font-family:arial; text-align:center;">', Currency, '</td><td style="color:#fff;font-weight:bold;font-size:8pt;font-family:arial; text-align:center;">', Rate, '</td></tr>');
	}
		
	AddCurrencyRate_Header("Mã", "Bán ra");
	for(var i=0;i<vForexs.length;i++){
		if (typeof(vForexs[i]) !='undefined' && typeof(vCosts[i]) !='undefined'){
		    AddCurrencyRate(vForexs[i], vCosts[i]);
		}
	}


	AddForexFooter();
}
ShowForexRate();

function AddForexHeader(Name, Header, Buttons, Symbol, AddChildTable)
{
	document.writeln('<table width="100%" border=0 cellspacing=0 cellpadding=1 bgcolor="#0167a9"><tr><td>');

	if (Header!='')
	{
	}

	//document.writeln('<table width="100%" border=0 cellspacing=0 cellpadding=0 id="tIDM_', Name, '"><tr><td><div class=BreakLine id="IDM_', Name, '">');
	document.writeln('<table width="100%" border=0 cellspacing=0 cellpadding=0><tr><td id="IDM_', Name, '">');
	document.writeln('<table width="100%" border=0 cellspacing=0 cellpadding=0><tr><td style="background-color:#ffffff;">');
	if (typeof(AddChildTable)=='undefined')
	{
		document.writeln('<div style="position:related; width:100%;background-color:#ffffff;">');
		document.writeln('<table align=center width="100%" cellspacing=0 cellpadding=0 border=1>');
		LastChild = 1;
	}
	else
	{
		LastChild = 0;
	}
	return true;
}

function AddForexFooter()
{
	document.writeln('</table>');
	document.writeln('</div>');
	document.writeln('</td></tr>');
	document.writeln('<tr bgcolor="#ffffff"><td colspan=1 class=BoxItem align=center><i>(Ngu&#7891;n: NH Ngo&#7841;i th&#432;&#417;ng VN)</td></tr>');
	document.writeln('</table>');
	document.writeln('</td></tr></table>');
	document.writeln('</td></tr></table>');
}