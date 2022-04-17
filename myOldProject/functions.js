(function(){
	var s = window.location.search.substring(1).split('&');

	if(!s.length) return;

	window.$_GET = {};

	for(var i  = 0; i < s.length; i++) {

		var parts = s[i].split('=');

		window.$_GET[unescape(parts[0])] = unescape(parts[1]);

	}

}())

  arg=[]

function leerer_text(Str){

	for(i=0;i<Str.length;i++){
	  sub=Str.substr(i,1);
	
	  if(sub!=" "){
		  arg.push(sub);
	  }
	}

	newStr=arg.join("");

	if (newStr=="") {
		return true;
	}
	else {
		return false;
	}
}


function fenster_oeffnen(fenster,att) {
	var x;
	x=window.open(fenster,null,att);
	return;
}

function out(s)
{
        document.write(s);
}

function outhr(s)
{
        document.write("<hr>" + s +"<hr>");
}

function isDatum(d)
{
        //hier soll überprüft werden, ob der übergebene Parameter ein gültiges Datum im Format yyyy-mm-tt ist


        //handelt es sich um eine Zahl - wenn die Bindestriche eliminiert werden?
        var d_neu=d.substr(0,4);    //ersten Datumsteil an String anhängen
        d_neu+=d.substr(5,2);       //zweiten Datumsteil an String anhängen
        d_neu+=d.substr(8,2);       //dritten Datumsteil an String anhängen

        if (isNaN(d_neu))
                {
                return false;
                }

        //sind es 10 Zeichen?
        if (d.length!=10)
                {
                return false;
                }
        //sind die ersten 4 Zeichen eine gültige Jahreszahl zwischen 1970 und 3000
        var datum = d.substr(0,4);
        if (datum<1970 || datum>3000)
                {
                return false;
                }

        //ist das nächste Zeichen ein Bindestrich?
        var s=d.substr(4,1);
        if (s!="-")
            {
            return false;
            }

        //sind die nächsten 2 Zeichen eine gültige Monatsangabe
        var monat = d.substr(5,2);
        if (monat<1 || monat>12)
                {
                return false;
                }

        //ist das nächste Zeichen ein Bindestrich?
        var s=d.substr(7,1);
        if (s!="-")
            {
            return false;
            }


        //sind die nächsten 2 Zeichen eine gültige Tagesangabe zwischen 1 und 31?
        var tag = d.substr(8,2);
        if (tag<1 || tag>31)
                {
                return false;
                }

        //wenn er bis hierher kommt, dann handelt es sich um ein Datum
        return true;

}

function isNumber(z) {
	if (isNaN(z)) {
		return false;	
	}
	else {
		return true;	
	}
}
