//verwijder functie, kan alleen verwijderd worden als de status vna de medewerker inactief is
function bevestigDelete(el) {
    const isActief = el.getAttribute('data-isactief');

    if (isActief === "1") {
        alert("Deze medewerker is actief en kan niet worden verwijderd.");
        return false;
    }

    return confirm("Weet je zeker dat je deze medewerker wilt verwijderen?");
}
