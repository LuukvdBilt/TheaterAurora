document.addEventListener('DOMContentLoaded', () => {
    // Dummydata om te simuleren (kan later via fetch vervangen worden)
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
    const feedbackBox = document.querySelector('#feedback'); // Een div voor meldingen

    /**
     * Genereert de rijen van de medewerkers-tabel
     */
    function renderTable() {
        tbody.innerHTML = '';

        if (dummyData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center">Er zijn geen Medewerkers geregistreerd.</td></tr>`;
            showFeedback("Geen medewerkers gevonden.", "warning");
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

            // Voeg klik-event toe om medewerker te verwijderen
            tr.querySelector('.btn-delete').addEventListener('click', () => {
                dummyData = dummyData.filter(m => m.Id !== medewerker.Id);
                renderTable();
                showFeedback(`Medewerker met ID ${medewerker.Id} verwijderd.`, "success");
            });

            tbody.appendChild(tr);
        });
    }

    /**
     * Laat feedback zien aan de gebruiker
     * @param {string} message - De tekst van de melding
     * @param {string} type - Bootstrap type: success | danger | warning
     */
    function showFeedback(message, type = 'info') {
        feedbackBox.innerHTML = `
            <div class="alert alert-${type}" role="alert">
                ${message}
            </div>
        `;
        setTimeout(() => feedbackBox.innerHTML = '', 2000); // Verdwijn na 2 sec
    }

    renderTable();
});
