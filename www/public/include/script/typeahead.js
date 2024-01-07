ATOUM_EVENTS.addEventListener("onTypeaheadModify", bindActorsAndTagsInURL);

function typeaheadSearch(field, type) {
    const input = document.getElementById(field);
    const zone = document.getElementById(field.concat('-result'));

    if (input.value.length === 0) {
        zone.innerHTML = '';
        zone.classList.remove('active');
        return;
    }

    zone.classList.add('active');

    const url = new URL(func('data/typeaheadSearch'));
    url.searchParams.set('type', type);
    url.searchParams.set('field', input.id);
    url.searchParams.set('search', input.value);
    putFrom(url, zone.id);
}

function typeaheadOnKey(field) {
    if (event.key === "Enter") typeaheadAdd(field);
}

function typeaheadAdd(field, value = null, callback = null) {
    const input = document.getElementById(field);
    const zone = document.getElementById(field.concat("-input"));
    const finalValue = value === null ? input.value : value;
    let newDeleteButton, newField, newDiv;

    newDiv = document.createElement("div");
    newDiv.id = finalValue.replace(/ /g, "-").toLowerCase() + "-input-container";
    newDiv.classList.add("input");

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
        typeaheadRemove(field, newDiv.id);
    };

    newDiv.appendChild(newField);
    newDiv.appendChild(newDeleteButton);
    zone.insertBefore(newDiv, zone.firstChild);

    input.value = "";
    typeaheadSearch(field, 0);
    ATOUM_EVENTS.dispatchEvent("onTypeaheadModify", field);
}

function typeaheadRemove(field, div) {
    document.getElementById(div).remove();
    ATOUM_EVENTS.dispatchEvent("onTypeaheadModify", field);
}

function bindActorsAndTagsInURL(field) {
    if (field === "actor-filter" || field === "tag-filter") {
        let actors = [];
        let inputs = document.querySelectorAll('input[name=\"' + "actor-filter[]" + '\"]');
        inputs.forEach(function (input) {
            actors.push(input.value);
        });
        let tags = [];
        inputs = document.querySelectorAll('input[name=\"' + "tag-filter[]" + '\"]');
        inputs.forEach(function (input) {
            tags.push(input.value);
        });

        setParams("actors", actors);
        setParams("tags", tags);
    }
}