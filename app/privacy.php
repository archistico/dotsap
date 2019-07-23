<?php
namespace App;

class Privacy
{
    // Bisogna essere loggati
    public function beforeroute($f3)
    {
        $auth = \App\Auth::Autentica($f3);
        if (!$auth) {
            $f3->set('logged', false);
            $f3->reroute('/login');
        } else {
            $f3->set('logged', true);
        }
    }

    public function Home($f3)
    {
        $listaAlfabetica = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "X", "Y", "Z"];
        $f3->set('lista', $listaAlfabetica);

        $f3->set('titolo', 'Privacy');
        $f3->set('contenuto', 'privacy.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Lista($f3, $params)
    {
        $lettera = $params['lettera'];
        $f3->set('lettera', $lettera);

        $lista = Paziente::ReadByLetter($lettera);

        $f3->set('lista', $lista);
        $f3->set('titolo', 'Privacy');
        $f3->set('contenuto', 'privacylista.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function MakePDF($f3, $params)
    {
        $id = $params['id'];
        $paz = Paziente::ReadByID($id);

        $sizeFontGrande = 10;
        $sizeFontPiccolo = 8;

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(12, 12, 12);
        $pdf->SetFont('Arial','B',$sizeFontGrande);
        $pdf->Cell(0,10,"INFORMATIVA PER IL TRATTAMENTO DEI DATI SENSIBILI", '', '', 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',$sizeFontPiccolo);
        $txt = "Gentile ".$paz->getPrefisso().", ai sensi del Regolamento UE 2016/679 del Parlamento Europeo e del Consiglio, relativo alla protezione delle persone fisiche con riguardo al trattamento dei dati personali, nonché alla libera circolazione di tali dati (\"Regolamento generale sulla protezione dei dati\"), il trattamento dei dati e delle informazioni che La riguardano sarà effettuato in conformità ai principi di liceità, correttezza e trasparenza, in maniera compatibile, nonché adeguata, pertinente e limitata a quanto necessario rispetto alle finalità di tale trattamento e sicura. In particolare, i Suoi dati personali di carattere genetico, biometrico e intesi a identificare in modo univoco una persona fisica, nonché quelli relativi alla Sua salute o alla Sua vita sessuale o al Suo orientamento sessuale potranno essere trattati, oltre che negli specifici casi disciplinati dall'art. 9 del Regolamento UE succitato, previa prestazione del consenso esplicito da parte Sua.";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0,5, $txt);

        $txt = "Ai sensi degli artt. 13 e 14 del Reg. UE 2016/679 Le forniamo, quindi, le seguenti informazioni: 
a) i dati sensibili da Lei forniti verranno trattati per le seguenti finalità: ottemperanza agli obiettivi ed alle cure erogate dal Servizio Sanitario Nazionale; 
b) titolare del trattamento è CHRISTINE ROLLANDIN (CF: RLLCRS84C65E379H); 
c) (eventuale) responsabile della protezione dei dati è (indicare identità e dati di contatto);
d) destinatari dei Suoi dati personali, in ragione della organizzazione del presente studio medico, saranno i seguenti soggetti: ";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0,5, $txt);

        $txt = "• ai Suoi dati personali e sensibili, per ragioni che attengono alla migliore esecuzione dell'incarico professionale attribuito al medico, potranno avere accesso i collaboratori e/o i segretari presenti nello studio medico, nonché eventuali infermieri:
Acconsento    Non Acconsento 
• ai Suoi dati personali e sensibili per ragioni di cura della Sua persona potranno avere accesso altri medici sostituti presenti nello studio medico:
Acconsento    Non Acconsento 
• ai Suoi dati personali e sensibili per ragioni di cura della Sua persona potranno avere accesso altri medici di medicina generale componenti l'associazione:
Acconsento    Non Acconsento  
• ai Suoi dati personali e sensibili, per ragioni che attengono la migliore organizzazione del lavoro prestato dal medico, potranno avere accesso i consulenti fiscali da quest'ultimo nominati, nei limiti in cui ciò si renda utile e necessario per l'adempimento dell'incarico professionale:
Acconsento    Non Acconsento  
• ai Suoi dati personali e sensibili, per ragioni che attengono la migliore organizzazione del lavoro prestato dal medico, potranno avere accesso i consulenti informatici / software house da quest'ultimo nominati, nei limiti in cui ciò si renda utile e necessario per l'adempimento dell'incarico professionale (assistenza, manutenzione e fornitura anche in remoto dei sistemi informatici):
Acconsento    Non Acconsento ";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0,5, $txt);

        $txt = "e) è in suo diritto delegare soggetti terzi, di sua fiducia, al ritiro o alla consegna di documentazione sanitaria che la riguarda, soggetti che verranno, anche verbalmente, indicati al medico o ai suoi collaboratori e sostituti, con esonero di ogni responsabilità al riguardo nei confronti del medico; 
f) i dati da Lei forniti potrebbero, in virtù di norme legali e regolamentari anche regionali imposta al medico di medicina generale, tempo per tempo vigenti, essere inoltrati o comunicati ad Enti o soggetti terzi (quali a titolo meramente esemplificativo, ASL, Regione, Ministeri etc.) e che il medico, successivamente alla trasmissione del dato è esente da responsabilità per l'uso, la perdita o la alterazione del dato personale o sensibile da parte di tali soggetti terzi. La informiamo, altresì, che, nel caso in cui Lei fornirà i dati personali di cui sopra: ";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0,5, $txt);

        $txt = "• i Suoi dati personali saranno conservati per il seguente periodo: 10 anni; 
• è Suo diritto chiedere al titolare del trattamento l'accesso ai dati personali e la rettifica o la cancellazione degli stessi; 
• è altresì Suo diritto chiedere al titolare del trattamento, anche rispetto a singole categorie di persone che possono essere destinatari dei Suoi dati, la limitazione, del trattamento che La riguarda, ovvero di opporsi al trattamento, o ancora di ottenere la portabilità dei dati in questione; 
• è inoltre Suo diritto revocare il consenso al trattamento dei dati precedentemente fornito; è Suo diritto proporre reclamo a un'autorità di controllo; 
• il trattamento dei dati personali e sensibili di cui sopra discende dall'adempimento di un obbligo legale, per cui dalla mancata comunicazione di tali dati (anche se derivante dal rifiuto di prestare il consenso, ovvero dalla revoca dello stesso) potrà discendere l'impossibilità giuridica di effettuare le prestazioni che costituiscono la base legale del trattamento dei Suoi dati; 
• è Suo diritto accedere ai dati personali trattati e conseguire le informazioni di cui all'art. 15 del Regolamento UE 2016/679, nonché ottenere copia degli stessi, laddove in caso di ulteriori copie il titolare del trattamento Le potrà richiedere il pagamento di un contributo spese ragionevole. ";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0,5, $txt);

        $pdf->Ln(2);
        $txt = "CONSENSO PER IL TRATTAMENTO DEI DATI PERSONALI";
        $pdf->SetFont('Arial','B',$sizeFontGrande);
        $pdf->Cell(0,10,$txt, '', '', 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','',$sizeFontPiccolo);
        // COGNOME NOME
        if($paz->sesso == "M") {
            $txt = "Il sottoscritto: ". $paz->cognome. " " . $paz->nome;
        } else {
            $txt = "La sottoscritta: ";
        }
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0,5, $txt);

        $txt = "Nato il: " . $paz->datanascita;
        $pdf->MultiCell(0,5, $txt);

        $txt = "Codice fiscale: " . $paz->codicefiscale;
        $pdf->MultiCell(0,5, $txt);
        $txt = "Residente: " . $paz->indirizzo . " - " . $paz->citta;
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0,5, $txt);
        $pdf->Ln(2);
        $txt = "ACCONSENTE";
        $pdf->SetFont('Arial','B',$sizeFontGrande);
        $pdf->Cell(0,10,$txt, '', '', 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','',$sizeFontPiccolo);
        $txt = "al trattamento dei propri dati personali, ai sensi degli arti. 6 e 7 del Regolamento UE 2016/679, secondo quanto indicato nell'informativa allegata, che dichiara di avere ricevuto in maniera chiara ed esplicita e di avere compiutamente compreso.";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0,5, $txt);

        $txt = "Data                                                      Firma";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->Ln(2);
        $pdf->MultiCell(0,5, $txt);

        $pdf->Output();
    }

    public function Modifica($f3, $params)
    {
        $f3->reroute('/privacy');
    }
}
