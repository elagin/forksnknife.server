/* +
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


removeIngredient = function (el) {
    el.parentNode.parentNode.remove();
};

removeStep = function (el) {
    el.parentNode.parentNode.remove();
};

addStep = function (idx, desc, time, photo) {
    var tr = document.createElement('tr');

    var tdDesc = addTextArea('desc', desc);
    tr.appendChild(tdDesc);

    var tdTime = addInputStep(idx, 'time', time, 5);
    tr.appendChild(tdTime);

    var tdPhoto = addInputStep(idx, 'photo', photo, 10);
    tr.appendChild(tdPhoto);

    var tdDel = document.createElement('td');
    tdDel.innerHTML = '<button onclick="removeStep(this)">Удалить</button>';
    tr.appendChild(tdDel);

    var tableRef = stepsTable.querySelector('tbody');
    tableRef.appendChild(tr);
    tableRef.setAttribute('data-max_index', idx++);

}

addInputStep = function (idx, name, value, size) {
    var td = document.createElement('td');
    value = value || '';
    var str = '<INPUT type="text" name=step[' + idx + '][' + name + '] maxlength="' + size + '" size="' + size + '" value="' + String(value) + '"/>';
    td.innerHTML = str;
    return td;
}

addIngredient = function (idx, name, count, unit) {
    var tr = document.createElement('tr');

    var hiddenID = document.createElement("input");
    hiddenID.setAttribute("type", "hidden");
    hiddenID.setAttribute("name", 'ingredient[' + idx + '][id]');
    hiddenID.setAttribute("value", idx);
    tr.appendChild(hiddenID);

    var tdName = addInputIngredient(idx, 'name', name, 50)
    tr.appendChild(tdName);

    var tdCount = addInputIngredient(idx, 'count', count, 5)
    tr.appendChild(tdCount);

    var tdUnit = addInputIngredient(idx, 'unit', unit, 10)
    tr.appendChild(tdUnit);

    var tdDel = document.createElement('td');
    tdDel.innerHTML = '<button onclick="removeIngredient(this)">Удалить</button>';
    tr.appendChild(tdDel);

    var tableRef = ingredientsTable.querySelector('tbody');
    tableRef.appendChild(tr);
    tableRef.setAttribute('data-max_index', idx++);
}

addInputIngredient = function (idx, name, value, size) {
    var td = document.createElement('td');
    value = value || '';
    var str = '<INPUT type="text" name=ingredient[' + idx + '][' + name + '] maxlength="' + size + '" size="' + size + '" value="' + String(value) + '"/>';
    td.innerHTML = str;
    return td;
}

addTextArea = function (name, value) {
    var td = document.createElement('td');
    value = value || '';
    var str = '<textarea name="' + name + '" cols="80" rows="5" >' + value + '</textarea>';
    td.innerHTML = str;
    return td;
}

printIngredients = function () {
    for (var i = 0; i < data.i.length; i++) {
        var ingredient = data.i[i];
        addIngredient(i, ingredient.name, ingredient.count, ingredient.unit)
    }
};

printSteps = function () {
    for (var i = 0; i < data.s.length; i++) {
        var step = data.s[i];
        addStep(i, step.desc, step.time, step.photo)
    }
};