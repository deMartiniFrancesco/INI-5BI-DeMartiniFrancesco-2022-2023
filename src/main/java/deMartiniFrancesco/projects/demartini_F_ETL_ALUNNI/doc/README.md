# Program name: ETL_ALUNNI.java

---

## Consegna

Il Csv allegato contiene dati(alterati) estratti dal SI della scuola.

Creare una tabella adeguata e inserire i dati presenti nel file.

Nel caso di tuple con cognome, nome, matricola non valorizzati, la riga non va inserita.  
La procedura di ETL deve produrre un log (numero righe estratte, righe considerate errate).

Una volta creata e inizializzata la tabella, scrivere le query SQL per elencare:

- Comuni di residenza.
- Classi
- I componenti della classe 5BI in ordine alfabetico.
- Tutti gli alunni nati a maggio 2005.
- Tutti gli alunni che compiono gli anni oggi.
- Tutti gli alunni con il voto difi Matematica >= 9.
- Tutti gli alunni "secchioni" (media fra ITA ING e MAT > 8,5.
- Tutti gli alunni con il voto medio > 8 e 7 in comportamento.