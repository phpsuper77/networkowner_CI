<html>
<head>
</head>

<body>

<script type="text/javascript">

var today = new Date(); 
if (today.dst()) { alert ("Daylight savings time!"); }

Date.prototype.stdTimezoneOffset = function() {
    var jan = new Date(this.getFullYear(), 0, 1);
    var jul = new Date(this.getFullYear(), 6, 1);
    return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
}

Date.prototype.dst = function() {
    return this.getTimezoneOffset() < this.stdTimezoneOffset();
}
</script>
</body>
</html>