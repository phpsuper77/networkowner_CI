//
// Challenger Retirement Calculator
// Copyright (c) 2011 Challenger.  All rights reserved.
//
// http://www.challenger.com.au/about/ContactUs.asp
//

var Formats = {
    /*
        formatter_name: {
            to: function(val) {
                // code to format the raw value and send the string to browser
            },
            from: function(val) {
                // code to format string from browser and return raw value
            }
        }
    */
    string: {
        to: function(val) {
            return String(val);
        },
        from: function(val) {
            return String(val);
        }
    },
    excel_date: {
        to: function (val) {
            // eg input: new Date(1981,1,23) => 23/02/1981
            val = ExcelDateToJSDate(val);
            return Formats.date.to(val);
        },
        from: function (val) {
            val = Formats.date.from(val);
            return JSDateToExcelDate(val);
        }
    },
    longdate: {
        to: function (val) {
            val = ExcelDateToJSDate(val);
            // eg input: new Date(1981,1,23) => 23/02/1981
            if (!(val instanceof Date)) {
                throw new Error("DATE: Not a date [" + val.toString() + "]");
            }
            else {
                var day = val.getDate().toString();
                switch (day.substr( day.length-1, 1 )) { // last character
                    case '1':
                        day += 'st';
                        break;
                    case '2':
                        day += 'nd';
                        break;
                    case '3':
                        day += 'rd';
                        break;
                    default:
                        day += 'th';
                        break;
                }
                return day + ' ' + Months[val.getMonth()] + ' ' + val.getFullYear();
            }
        },
        from: function (val) {
            // eg input: Wed Feb 23 1981 => new Date(1981,1,23)
            return Date.parse(val);
        }
    },
    date: {
        to: function (val) {
            // eg input: new Date(1981,1,23) => 23/02/1981
            if (!(val instanceof Date)) {
                throw new Error("DATE: Not a date [" + val.toString() + "]")
            }
            else {
                var day = val.getDate().toString().length == 1 ? '0' + val.getDate().toString() : val.getDate().toString();
                var month = (Number(val.getMonth())+1).toString().length == 1 ? String('0' + (Number(val.getMonth())+1).toString()) : (Number(val.getMonth())+1).toString();

                return day + "/" + month + "/" + val.getFullYear();
            }
        },
        from: function (val) {
            // eg input: 23/2/1981 => new Date(1981,1,23)

            // split into usable parts
            var date_parts = val.split('/');
            var year = Number(date_parts[2]);
            var month = Number(date_parts[1]) - 1;
            var day = Number(date_parts[0]);

            // create the date object
            var date = new Date(year, month, day);

            // Check the newly created date object is correct by
            // checking against the parsed string values
            if (year != date.getFullYear()
                || month != date.getMonth()
                || day != date.getDate()
            ) {
                throw new Error("DATE ERROR");
            }
            else {
                return date;
            }
        }
    },
    dollars: {
        to: function (val) {
            return "$ " + val;
        },
        from: function (val) {
            // remove $'s and spaces
            return val.replace(/[$\s]/g, '');
        }
    },
    rounded: {
        to: function (val) {
            // rounded to whole numbers
            return Math.round(val);
        },
        from: function (val) {
            // cannot unround a rounded number
            return val;
        }
    },
    commas: {
        to: function(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        },
        from: function(val) {
            return val.replace(/,/g, '');
        }
    },
    // info/title/output-only use this one
    money_rounded: {
        to: function (val) {
            // $ with commas and rounded to whole numbers
            return Formats.dollars.to(Formats.commas.to(Formats.rounded.to(val)));
        },
        from: function (val) {
            return Number(Formats.rounded.from(Formats.commas.from(Formats.dollars.from(val))));
        }
    },
    // money inputs use this one
    money_rounded_input: {
        to: function (val) {
            // $ with commas and rounded to whole numbers
            return Formats.commas.to(Formats.rounded.to(val));
        },
        from: function (val) {
            // Note: this still tries to remove any $ and spaces
            return Number(Formats.rounded.from(Formats.commas.from(Formats.dollars.from(val))));
        }
    },
    number: { // assume it's to/from a string
        to: function (val) {
            return String(val);
        },
        from: function (val) {
            return Number(val);
        }
    },
    number_or_word: { // assume it's to/from a string
        to: function (val) {
            return String(val);
        },
        from: function (val) {
            if (String(val).match(/[0-9]+(\.[0-9]+)?/i)) {
                return Number(val);
            }
            else {
                return String(val);
            }
        }
    },
    percentage: { // assume it's to/from a string
        to: function (val) {
            return round_to(Number(val) * 100, 2) + '%';
        },
        from: function (val) {
            return Number(Number(val.replace('%',''))/100);
        }
    },
    percentage_no_suffix: { // assume it's to/from a string
        to: function (val) {
            return round_to(Number(val) * 100, 2);
        },
        from: function (val) {
            return Number(Number(val)/100);
        }
    },
    percentage_no: { // assume it's to/from a string
        to: function (val) {
            return round_to(Number(val) * 100, 2);
        },
        from: function (val) {
            return Number(Number(val.replace('%',''))/100);
        }
    },
    
    table: {
        to: function (val) {
            val = val.data;
            var output = '<hr width="100%"><div><p><p><p><table class="datasets">';
            for (var i=1; i<=val.length; i++) {
                output += '<tr><th>Dataset: ' + i + '</th>';
                for (var c=0; c<val[i-1].length; c++) {
                    output += '<td>'+val[i-1][c]+'</td>';
                }
                output += '<tr>';
            }
            output += '</table></div><hr width="100%">';
            return output;
        }
    }
};

function addPercentagesToArray(arr) {
	var result = [];
	for (var i = 0; i < arr.length; i++) {
		result.push([arr[i], arr[i] + "%"]);
	}
	return result;
}

function addDollarCommasToArray(arr) {
	var result = [];
	for (var i = 0; i < arr.length; i++) {
		result.push([arr[i], '$ ' + Formats.commas.to(arr[i])]);
	}
	return result;
}

function numTicksForArray(arr, countTicks) {
	var max = Number.MIN_VALUE;
	for (var x = 0; x < arr.length; x++) {
		max = Math.max(max, arr[x]);
		//alert(arr[x]);
	}
	return arrayToNum(tickLabel(0, max, countTicks));
}

function numTicksForDoubleArray(doubleArray, countTicks, operation) {
	return arrayToNum(ticksForDoubleArray(doubleArray, countTicks, operation));
}

function arrayToNum(a) {
	for (var i = 0; i < a.length; i++) {
		a[i] = parseFloat(a[i]);
	}
	return a;
}

function ticksForDoubleArray(doubleArray, countTicks, operation) {
	var max = Number.MIN_VALUE;
	if (operation == "sum") {
		for (var y = 0; y < doubleArray[0].length; y++) {
			var s = 0;
			for (var x = 0; x < doubleArray.length; x++) {
				s += doubleArray[x][y];
			}
			max = Math.max(max, s);
		}
	} else {
		for (var x = 0; x < doubleArray.length; x++) {
			for (var y = 0; y < doubleArray[x].length; y++) {
				max = Math.max(max, doubleArray[x][y]);
			}
		}
	}
	return tickLabel(0, max, countTicks);
}

function tickLabel(min, max, ntick) {
       var range = nicenum(max - min, false);
       var d = nicenum(range/(ntick-1), true);
       var graphmin = Math.floor(min/d)*d;
       var graphmax = Math.ceil(max/d)*d;
       var nfrac = Math.max(-Math.floor(Math.log(d)/Math.log(10)),0);
       var result = [];
       for (var x = graphmin; x <= graphmax + .5*d; x+=d) {
               result.push(showDecimals(x, nfrac));
               // alert("tick at " + x + " " + nfrac + " " + showDecimals(x, nfrac));
       }
       return result;
}

function nicenum(x, round) {
       var nf;
       var exp = Math.floor(Math.log(x)/Math.log(10));
       var f = x/Math.pow(10, exp);
       if (round) {
               if (f < 1.5) { nf = 1; }
               else if (f < 3) { nf = 2; }
               else if (f < 7) { nf = 5; }
               else { nf = 10; }
       } else {
               if (f <= 1) { nf = 1; }
               else if (f <=2) { nf = 2; }
               else if (f <=5) { nf = 5; }
               else { nf = 10; }
       }
       return nf * Math.pow(10, exp);
}

function showDecimals(n, count) {
       if (n==0) {return '0';}
       var s = n + "";
       var o = '';
       var dotPos = s.search(/\./);
       if (dotPos == -1) {
               o = s;
               if (count > 0) {
                       o += ".";
                       for (var i = 0; i < count; i++ ) {
                               o += "0";
                       }
               }
       } else {
               for (var i = 0; i < dotPos; i++ ) {
                       o += s[i];
               }
               o += ".";
               for (var i = 0; i < count; i++ ) {
                       o += s[dotPos + 1 + i];
               }
       }
       return o;
}

