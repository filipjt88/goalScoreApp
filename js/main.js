let prevDataMap = { football: new Map(), basketball: new Map() };

async function loadResults() {
  try {
    const res  = await fetch('get_results.php');
    const data = await res.json();

    const footballTable   = document.querySelector('#footballTable tbody');
    const basketballTable = document.querySelector('#basketballTable tbody');

    function renderTable(table, newMatches, sport) {
      if (!newMatches || newMatches.length === 0) {
        table.innerHTML = '<tr><td colspan="4">Nema dostupnih utakmica</td></tr>';
        return;
      }
      const currentRowsMap = new Map();

      table.innerHTML = newMatches.map(match => {
             const id = match.id;
             currentRowsMap.set(id, match);

        return `
          <tr data-id="${id}">
            <td>${match.league}</td>
            <td>${match.home_team}</td>
            <td>${match.away_team}</td>
            <td>${match.home_score ?? '-'} : ${match.away_score ?? '-'}</td>
          </tr>
        `;
      }).join('');

      newMatches.forEach(match => {
        const prevMatch = prevDataMap[sport].get(match.id);
        if (prevMatch && (prevMatch.home_score !== match.home_score || prevMatch.away_score !== match.away_score)) {
          const row = table.querySelector(`tr[data-id="${match.id}"]`);
          if (row) {
            row.classList.add('highlight');
            // Fade-out posle 2 sekunde
            setTimeout(() => row.classList.remove('highlight'), 2000);
          }
        }
      });

      prevDataMap[sport] = currentRowsMap;
    }

    renderTable(footballTable, data.football, 'football');
    renderTable(basketballTable, data.basketball, 'basketball');

  } catch (err) {
    console.error("Greška pri učitavanju rezultata:", err);
  }
}

loadResults();
setInterval(loadResults, 10000);