function wpctFilter() {
    console.log("hi!");
    var teams = document.getElementById('teams').getElementsByTagName('li');
    var filterText = document.getElementById('teamfilter').value;
    for (var i = 0; i < teams.length; i++) {
	console.log(teams[i].innerHTML);
	console.log(filterText);
	if (teams[i].innerHTML.toLowerCase().indexOf(filterText.toLowerCase()) !== -1) {
	    teams[i].setAttribute('style', '');
	} else {
	    teams[i].setAttribute('style', 'display: none');
	}
    }
}
