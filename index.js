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

addStep = function (i, idx, desc, time, photo) {
    var tr = document.createElement('tr');

    var hiddenID = document.createElement("input");
    hiddenID.setAttribute("type", "hidden");
    hiddenID.setAttribute("name", 'step[' + i + '][id]');
    hiddenID.setAttribute("value", idx);
    tr.appendChild(hiddenID);
    /*    
     var hiddenRecipleID = document.createElement("input");
     hiddenID.setAttribute("type", "hidden");
     hiddenID.setAttribute("name", 'step[' + idx + '][' + reciple_id + ']');
     hiddenID.setAttribute("value", reciple_id);
     tr.appendChild(hiddenRecipleID);
     */
    var tdDesc = addTextArea(i, 'description', desc);
    tr.appendChild(tdDesc);

    var tdTime = addInputStep(i, 'time', time, 5);
    tr.appendChild(tdTime);

    var tdPhoto = addInputStep(i, 'photo', photo, 10);
    tr.appendChild(tdPhoto);

    var tdDel = document.createElement('td');
    tdDel.innerHTML = '<button onclick="removeStep(this)">Удалить</button>';
    tr.appendChild(tdDel);

    var tableRef = stepsTable.querySelector('tbody');
    tableRef.appendChild(tr);
    tableRef.setAttribute('data-max_index', idx++);

};

addInputStep = function (idx, name, value, size) {
    var td = document.createElement('td');
    value = value || '';
    var str = '<INPUT type="text" name=step[' + idx + '][' + name + '] maxlength="' + size + '" size="' + size + '" value="' + String(value) + '"/>';
    td.innerHTML = str;
    return td;
};

addIngredient = function (i, idx, name, count, unit) {
    var tr = document.createElement('tr');
    var tableRef = ingredientsTable.querySelector('tbody');
    if(typeof i == "undefined")
        i = tableRef.getAttribute('data-max_index');

    var hiddenID = document.createElement("input");
    hiddenID.setAttribute("type", "hidden");
    hiddenID.setAttribute("name", 'ingredient[' + i + '][id]');
    hiddenID.setAttribute("value", idx);
    tr.appendChild(hiddenID);

    var tdName = addInputIngredient(i, 'name', name, 50)
    tr.appendChild(tdName);

    var tdCount = addInputIngredient(i, 'count', count, 5)
    tr.appendChild(tdCount);

    var tdUnit = addInputIngredient(i, 'unit', unit, 10)
    tr.appendChild(tdUnit);

    var tdDel = document.createElement('td');
    tdDel.innerHTML = '<button onclick="removeIngredient(this)">Удалить</button>';
    tr.appendChild(tdDel);

    //var tableRef = ingredientsTable.querySelector('tbody');
    tableRef.appendChild(tr);
    tableRef.setAttribute('data-max_index', idx++);
};

addInputIngredient = function (idx, name, value, size) {
    var td = document.createElement('td');
    value = value || '';
    var str = '<INPUT type="text" name=ingredient[' + idx + '][' + name + '] maxlength="' + size + '" size="' + size + '" value="' + String(value) + '"/>';
    td.innerHTML = str;
    return td;
}

addTextArea = function (idx, name, value) {
    var td = document.createElement('td');
    value = value || '';
    var str = '<textarea name=step[' + idx + '][' + name + '] cols="80" rows="5" >' + value + '</textarea>';
    td.innerHTML = str;
    return td;
};

printIngredients = function () {
    for (var i = 0; i < data.i.length; i++) {
        var ingredient = data.i[i];
        addIngredient(i, ingredient.id, ingredient.name, ingredient.count, ingredient.unit);
    }
};

printSteps = function (/*reciple_id*/) {
    for (var i = 0; i < data.s.length; i++) {
        var step = data.s[i];
        addStep(i, step.id, step.desc, step.time, step.photo);
    }
};