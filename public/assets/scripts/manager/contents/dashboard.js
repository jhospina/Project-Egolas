

$(document).ready(function () {
    //Estado de usuarios
    new Chart(document.getElementById("chart-users-state").getContext("2d")).Pie(dataSetUsers_state);
    //Tipos de usuarios
    new Chart(document.getElementById("chart-users-role").getContext("2d")).Pie(dataSetUsers_role);
    //Producciones
    new Chart(document.getElementById("chart-productions").getContext("2d")).Pie(dataSetProductions);

});

