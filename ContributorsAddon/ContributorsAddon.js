//JS file for ContributorsAddon
/*
* When JS is supported, it works - when JS is NOT supported, 
* it just does nothing and doesn't interfere with the core 
* Contributors Extension
*
* @author Tim Laqua <t.laqua@gmail.com>
*/

function setupContributionsAddon() {
	var contributorsLink = document.getElementById('t-contributors').firstChild;
	if (contributorsLink != null) {
		contributorsLink.onmouseover = showContributors;
		contributorsLink.onmouseout = hideContributors;
		var cDiv = document.createElement('div');
		cDiv.id = 'contributorsDiv';
		cDiv.className = 'contributorsDivHide';
		cDiv.innerHTML = contributorsText;
		cDiv.onmouseover = showContributors;
		cDiv.onmouseout = hideContributors;
		var gWrapper = document.getElementById('globalWrapper');
		document.body.insertBefore(cDiv,gWrapper);
	}
}

function showContributors() {
	var contributorsDiv = document.getElementById('contributorsDiv');
	if (contributorsDiv != null) {
		contributorsDiv.className = 'contributorsDivShow pBody';
		var arrCoords = findPos(document.getElementById('t-contributors'));
		contributorsDiv.style.top = (arrCoords[1]-5) + 'px';
		contributorsDiv.style.left = (arrCoords[0]+40) + 'px';
	}
}

function hideContributors() {
	var contributorsDiv = document.getElementById('contributorsDiv');
	if (contributorsDiv != null) {
		contributorsDiv.className = 'contributorsDivHide';
	}
}

function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	return [curleft,curtop];
}
addOnloadHook(setupContributionsAddon);