async function loadResults() {
  try {
    const res = await fetch('get_results.php');
    const data = await res.json();

    const footballTable = document.querySelector('#footballTable tbody');
    const basketballTable = document.querySelector('#basketballTable tbody');

    // Football
    if (data.football && data.football.length > 0) {
      footballTable.innerHTML = data.football.map(match => `
        <tr>
          <td>${match.league}</td>
          <td>${match.home_team}</td>
          <td>${match.away_team}</td>
          <td>${match.home_score ?? '-'} : ${match.away_score ?? '-'}</td>
        </tr>
      `).join('');
    } else {
      footballTable.innerHTML = '<tr><td colspan="4">Nema dostupnih utakmica</td></tr>';
    }

    // Basketball
    if (data.basketball && data.basketball.length > 0) {
      basketballTable.innerHTML = data.basketball.map(match => `
        <tr>
          <td>${match.league}</td>
          <td>${match.home_team}</td>
          <td>${match.away_team}</td>
          <td>${match.home_score ?? '-'} : ${match.away_score ?? '-'}</td>
        </tr>
      `).join('');
    } else {
      basketballTable.innerHTML = '<tr><td colspan="4">Nema dostupnih utakmica</td></tr>';
    }

  } catch (err) {
    console.error("Greška pri učitavanju rezultata:", err);
  }
}

// Prvi load odmah
loadResults();

// Auto refresh svake 30 sekundi
setInterval(loadResults, 10000);