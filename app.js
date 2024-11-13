const express = require('express');
const app = express();

const data =
{
    "suhu_max": "36",
    "suhu_min": "21",
    "suhu_rata": "28.35",
    "nilai_suhu_max_humid_max": [
      {
        "idx": "101",
        "suhun": 36,
        "humid": 36,
        "kecerahan": "25",
        "timestamp": "2010-09-18 07:23:48"
      },
      {
        "idx": "226",
        "suhun": 21,
        "humid": 21,
        "kecerahan": "27",
        "timestamp": "2011-05-02 12:29:34"
      }
    ],
    "month_year": "5-2011"
}

app.get('/data', (req, res) => {
    res.json(data);
  });
  
  const port = 3000;
  app.listen(port, () => {
    console.log(`Server berjalan di http://localhost:${port}`);
  });