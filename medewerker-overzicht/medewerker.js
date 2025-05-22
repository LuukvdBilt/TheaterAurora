document.addEventListener('DOMContentLoaded', () => {
    let dummyData = [
        {
            Id: 1,
            Nummer: 12345,
            Medewerkersoort: 'Manager',
            Isactief: 1,
            Opmerking: 'Team lead',
            Datumaangemaakt: '2025-01-15 10:30:00',
            Datumgewijzigd: '2025-05-20 09:00:00',
            Voornaam: 'Jan',
            Tussenvoegsel: '',
            Achternaam: 'Jansen'
        },
        {
            Id: 2,
            Nummer: 54321,
            Medewerkersoort: 'Admin',
            Isactief: 0,
            Opmerking: '',
            Datumaangemaakt: '2024-11-01 19:45',
            Datumgewijzigd: '2025-04-15 19:46',
            Voornaam: 'Maria',
            Tussenvoegsel: 'van',
            Achternaam: 'Dijk'
        }
    ];

    const tbody = document.querySelector('#medewerkerTable tbody');
    function renderTable() {
        tbody.innerHTML = '';

        if (dummyData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center">Er zijn geen Medewerkers geregistreerd.</td></tr>`;
            return;
        }

        dummyData.forEach(medewerker => {
            const status = medewerker.Isactief == 1 ? 'Actief' : 'Inactief';

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${medewerker.Id}</td>
                <td>${medewerker.Nummer}</td>
                <td>${medewerker.Medewerkersoort}</td>
                <td>${status}</td>
                <td>${medewerker.Opmerking || ''}</td>
                <td>${medewerker.Datumaangemaakt}</td>
                <td>${medewerker.Datumgewijzigd}</td>
                <td>
                    <button class="btn btn-danger btn-sm btn-delete">Verwijder</button>
                </td>
            `;

            // Add event listener to delete button
            tr.querySelector('.btn-delete').addEventListener('click', () => {
                // Remove medewerker from dummyData by Id
                dummyData = dummyData.filter(m => m.Id !== medewerker.Id);
                renderTable();
            });

            tbody.appendChild(tr);
        });
    }

    renderTable();
});
