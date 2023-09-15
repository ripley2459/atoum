function typeaheadSearch(field, type) {
    const input = document.getElementById(field);
    const zone = document.getElementById(field.concat('-result'));

    if (input.value.length === 0) {
        zone.innerHTML = '';
        zone.classList.remove('active');
        return;
    }

    zone.classList.add('active');
    let url = new URL(window.location.origin.concat('/includes/functions/typeaheadSearch.php'));
    url.searchParams.set('type', type);
    url.searchParams.set('field', input.id);
    url.searchParams.set('search', input.value);

    putFrom(url, zone.id);
}

function typeaheadAdd(field, value = null) {
    const input = document.getElementById(field);
    const zone = document.getElementById(field.concat('-input'));
    const finalValue = value === null ? input.value : value;
    let newDeleteButton, newField, newDiv;

    newDiv = document.createElement('div');
    newDiv.id = finalValue.replace(/ /g, "-").toLowerCase() + "-input-container";
    newDiv.classList.add("input");
    newDiv.classList.add("u-full-width");

    newField = document.createElement("input");
    newField.type = "text";
    newField.classList.add(input.id.replace(/ /g, "-").toLowerCase() + "-value");
    newField.setAttribute("value", finalValue); // Bugged ?
    newField.readOnly = true;
    newField.name = field.concat("[]");

    newDeleteButton = document.createElement("button");
    newDeleteButton.innerHTML = "x";
    newDeleteButton.type = "button";
    newDeleteButton.onclick = function () {
        typeaheadRemove(newDiv.id);
    };

    newDiv.appendChild(newField);
    newDiv.appendChild(newDeleteButton);
    zone.insertBefore(newDiv, zone.firstChild);

    input.value = "";
    typeaheadSearch(field, 0);
}

function typeaheadRemove(div) {
    document.getElementById(div).remove();
}

function typeaheadOnKey(field) {
    if (event.key === "Enter") typeaheadAdd(field);
}
