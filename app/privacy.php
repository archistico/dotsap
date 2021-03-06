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

        $totaleprivacy = Paziente::ContaTotalePazienti();
        $totalefirmate = Paziente::ContaTotaleFirmate();

        $f3->set('totaleprivacy', $totaleprivacy);
        $f3->set('totalefirmate', $totalefirmate);
        $f3->set('totalemancanti', $totaleprivacy - $totalefirmate);

        if ($totaleprivacy == 0) {
            $percentuale = 0;
        } else {
            $percentuale = round(($totalefirmate / $totaleprivacy) * 100);
        }
        $f3->set('percentuale', $percentuale);

        $f3->set('titolo', 'Privacy');
        $f3->set('contenuto', '/privacy/privacy.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Lista($f3, $params)
    {
        $lettera = $params['lettera'];
        $f3->set('lettera', $lettera);

        $lista = Paziente::ReadByLetter($lettera);
        $f3->set('lista', $lista);

        // Generali
        $f3->set('titolo', 'Privacy');
        $f3->set('script', 'privacy.js');
        $f3->set('contenuto', '/privacy/privacylista.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function MakePDF($f3, $params)
    {
        $id = $params['id'];
        $paz = Paziente::ReadByID($id);

        $sizeFontGrande = 10;
        $sizeFontPiccolo = 8;

        $pdf = new \FPDF();
        $pdf->SetAutoPageBreak(false, 10);
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetFont('Arial', 'B', $sizeFontGrande);
        $pdf->Cell(0, 10, "INFORMATIVA PAZIENTE IN MATERIA DI PROTEZIONE DEI DATI PERSONALI AI SENSI DEL REG. UE 679/2016", '', '', 'L');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', $sizeFontPiccolo);
        $txt = "Gentile " . $paz->getPrefisso() . ", ai sensi del Regolamento UE 2016/679, relativo alla protezione delle persone fisiche con riguardo al trattamento dei dati personali, nonché alla libera circolazione di tali dati, il trattamento dei dati e delle informazioni che La riguardano sarà effettuato in conformità ai principi di liceità, correttezza e trasparenza, in maniera compatibile, nonché adeguata, pertinente e limitata a quanto necessario rispetto alle finalità di tale trattamento e sicura. In particolare, i Suoi dati personali di carattere genetico, biometrico e intesi a identificare in modo univoco una persona fisica, nonché quelli relativi alla Sua salute o alla Sua vita sessuale o al Suo orientamento sessuale potranno essere trattati, oltre che negli specifici casi disciplinati dall'art. 9 del Regolamento UE succitato, previa prestazione del consenso esplicito da parte Sua. Ai sensi degli artt. 13 e 14 del Reg. UE 2016/679 Le forniamo, quindi, le seguenti informazioni:";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0, 5, $txt);

        $responsabile = env("APP_RESPONSABILE");
        $txt = "a) i dati sensibili da Lei forniti verranno trattati per le seguenti finalità: ottemperanza agli obiettivi ed alle cure erogate dal S.S.N.;
b) titolare del trattamento è: $responsabile;
c) i destinatari dei Suoi dati personali, in ragione della organizzazione del presente studio medico, saranno i seguenti soggetti: ";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0, 5, $txt);

        $txt = "• per ragioni di cura della Sua persona potranno avere accesso i sostituti, i medici di medicina generale componenti l'associazione, i collaboratori di studio, nonché eventuali infermieri:
        Acconsento             Non Acconsento
• per ragioni di cura della Sua persona potranno avere accesso i gruppi di cura esterni (emergenza, reparti, specialisti):
        Acconsento             Non Acconsento
• per ragioni che attengono la migliore organizzazione del lavoro prestato dal medico, potranno avere accesso i consulenti fiscali da quest'ultimo nominati, nei limiti in cui ciò si renda utile e necessario per l'adempimento dell'incarico professionale:
        Acconsento             Non Acconsento
• per ragioni che attengono la migliore organizzazione del lavoro prestato dal medico, potranno avere accesso i consulenti informatici / software house da quest'ultimo nominati, nei limiti in cui ciò si renda utile e necessario per l'adempimento dell'incarico professionale (assistenza, manutenzione e fornitura anche in remoto dei sistemi informatici):
        Acconsento             Non Acconsento 
";

        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0, 5, $txt);

        $txt = "d) è in suo diritto delegare soggetti terzi, di sua fiducia, al ritiro o alla consegna di documentazione sanitaria che la riguarda, soggetti che verranno, anche verbalmente, indicati al medico o ai suoi collaboratori e sostituti, con esonero di ogni responsabilità al riguardo nei confronti del medico;
• desidera ricevere sul suo indirizzo di posta elettronica o sul suo numero di cellulare prescrizioni / ricette e autorizzare il Titolare all'invio della registrazione e all'utilizzo della piattaforma Millebook:
        Acconsento             Non Acconsento 
e) i dati da Lei forniti potrebbero, in virtù di norme legali e regolamentari anche regionali imposte al medico di medicina generale, tempo per tempo vigenti, essere inoltrati o comunicati ad Enti o soggetti terzi (quali a titolo meramente esemplificativo, ASL, Regione, Ministeri etc.) e che il medico, successivamente alla trasmissione del dato è esente da responsabilità per l'uso, la perdita o la alterazione del dato personale o sensibile da parte di tali soggetti terzi. La informiamo, altresì, che, nel caso in cui Lei fornirà i dati personali di cui sopra: ";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0, 5, $txt);

        $txt = "• i Suoi dati personali saranno conservati per il seguente periodo: 10 anni;
• è Suo diritto chiedere al titolare del trattamento l'accesso ai dati personali e la rettifica o la cancellazione degli stessi;
• è altresì Suo diritto chiedere al titolare del trattamento, anche rispetto a singole categorie di persone che possono essere destinatari dei Suoi dati, la limitazione, del trattamento che La riguarda, ovvero di opporsi al trattamento, o ancora di ottenere la portabilità dei dati in questione;
• è inoltre Suo diritto revocare il consenso al trattamento dei dati precedentemente fornito ed è Suo diritto proporre reclamo all'autorità di controllo;
• il trattamento dei dati personali e sensibili di cui sopra discende dall'adempimento di un obbligo legale, per cui dalla mancata comunicazione di tali dati (anche se derivante dal rifiuto di prestare il consenso, ovvero dalla revoca dello stesso) potrà discendere l'impossibilità giuridica di effettuare le prestazioni che costituiscono la base legale del trattamento dei Suoi dati;
• è Suo diritto accedere ai dati personali trattati e conseguire le informazioni di cui all'art. 15 del Regolamento UE 2016/679, nonché ottenere copia degli stessi, laddove in caso di ulteriori copie il titolare del trattamento Le potrà richiedere il pagamento di un contributo spese ragionevole. ";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0, 5, $txt);

        $txt = "CONSENSO PER IL TRATTAMENTO DEI DATI PERSONALI";
        $pdf->SetFont('Arial', 'B', $sizeFontGrande);
        $pdf->Cell(0, 10, $txt, '', '', 'C');
        $pdf->Ln(10);

        // rettangolini
        $pdf->Rect(13, 81, 3, 3, 'D');
        $pdf->Rect(38, 81, 3, 3, 'D');

        $pdf->Rect(13, 91, 3, 3, 'D');
        $pdf->Rect(38, 91, 3, 3, 'D');

        $pdf->Rect(13, 106, 3, 3, 'D');
        $pdf->Rect(38, 106, 3, 3, 'D');

        $pdf->Rect(13, 126, 3, 3, 'D');
        $pdf->Rect(38, 126, 3, 3, 'D');

        $pdf->Rect(13, 151, 3, 3, 'D');
        $pdf->Rect(38, 151, 3, 3, 'D');

        $pdf->SetFont('Arial', '', $sizeFontPiccolo);
        // COGNOME NOME
        if (empty($paz->codicefiscale)) {
            $paz_cf = "______________________________";    
        } else {
            $paz_cf = strtoupper($paz->codicefiscale);
        }

        if (empty($paz->telefono)) {
            $paz_telefono = "______________________________";    
        } else {
            $paz_telefono = strtolower($paz->telefono);
        }

        if (empty($paz->email)) {
            $paz_email = "______________________________";    
        } else {
            $paz_email = strtolower($paz->email);
        }

        if ($paz->sesso == "M") {
            $txt = "Il sottoscritto: " . strtoupper($paz->cognome) . " " . strtoupper($paz->nome) . ", nato il " . $paz->datanascita . ", residente: " . $paz->indirizzo . " - " . $paz->citta . ", codice fiscale: " . $paz_cf . ", telefono: " . $paz_telefono . ", email: " . $paz_email;
        } else {
            $txt = "La sottoscritta: " . strtoupper($paz->cognome) . " " . strtoupper($paz->nome) . ", nata il " . $paz->datanascita . ", residente: " . $paz->indirizzo . " - " . $paz->citta . ", codice fiscale: " . $paz_cf . ", telefono: " . $paz_telefono . ", email: " . $paz_email;
        }
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0, 5, $txt);

        $txt = "ACCONSENTE";
        $pdf->SetFont('Arial', 'B', $sizeFontPiccolo);
        $pdf->Cell(0, 10, $txt, '', '', 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', $sizeFontPiccolo);
        $txt = "al trattamento dei propri dati personali, ai sensi degli arti. 6 e 7 del Regolamento UE 2016/679, secondo quanto indicato nell'informativa allegata, che dichiara di avere ricevuto in maniera chiara ed esplicita e di avere compiutamente compreso.";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->MultiCell(0, 5, $txt);

        $txt = "Data " . date("d/m/Y") . "                            Firma";
        $txt = iconv('UTF-8', 'windows-1252', $txt);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 5, $txt);

        $titolo = "Privacy - " . $paz->cognome . " " . $paz->nome;
        $pdf->SetTitle($titolo);
        $pdf->Output('', $titolo . ".pdf");
    }

    private function ConvertBool($a)
    {
        if (!is_null($a)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function Modifica($f3)
    {
        $lettera = $f3->get('POST.input-lettera');
        $id = $f3->get('POST.input-id');
        $datafirma = $f3->get('POST.datafirma');
        $segreteria = $f3->get('POST.segreteria');
        $sostituti = $f3->get('POST.sostituti');
        $associati = $f3->get('POST.associati');
        $consulenti = $f3->get('POST.consulenti');
        $softwarehouse = $f3->get('POST.softwarehouse');
        $invioricette = $f3->get('POST.invioricette');
        
        Paziente::ModifyPrivacyByID($id, $datafirma, $this->ConvertBool($segreteria), $this->ConvertBool($sostituti), $this->ConvertBool($associati), $this->ConvertBool($consulenti), $this->ConvertBool($softwarehouse), $this->ConvertBool($invioricette));

        // Gestione email per Millebook
        $indirizzoemail = $f3->get('POST.indirizzoemail');
        $indirizzoemail = strtolower($indirizzoemail);

        if(!empty(trim($indirizzoemail))) {
            Paziente::ModifyEmailByID($id, $indirizzoemail);
        }

        $f3->reroute('/privacy/' . $lettera);
    }

    public function PazienteSearch($f3)
    {
        $f3->set('titolo', 'Cerca Paziente');
        $f3->set('contenuto', '/privacy/privacysearch.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function PazienteSearchList($f3)
    {
        $testoRicerca = Utilita::PulisciStringaVirgolette($f3->get('POST.nome'));
        $lista = Paziente::Search($testoRicerca);
        $f3->set('lista', $lista);

        // Generali
        $f3->set('titolo', 'Privacy');
        $f3->set('script', 'privacy.js');
        $f3->set('contenuto', '/privacy/privacysearchlist.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function TablePDF($f3)
    {
        $sizeFontGrande = 10;
        $sizeFontPiccolo = 8;
        $altezze_linea = 6;
        $larghezza_nome = 65;
        $larghezza_data = 18;
        $larghezza_privacy = 8;
        $larghezza_modello = 8;
        $larghezza_email = 57;

        $lista = Paziente::AllSigned();
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(8, 10, 8);
        $pdf->SetFont('Arial', 'B', $sizeFontGrande);
        $pdf->Cell(0, 10, "TABELLA PRIVACY", '', '', 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', $sizeFontPiccolo);

        // INTESTAZIONE TABELLA 

        $pdf->Cell($larghezza_nome, $altezze_linea, 'Cognome nome', 1, 0, 'C');
        $pdf->Cell($larghezza_data, $altezze_linea, 'Data', 1, 0, 'C');
        $pdf->Cell($larghezza_modello, $altezze_linea, 'Mod.', 1, 0, 'C');
        $pdf->Cell($larghezza_privacy, $altezze_linea, 'Seg.', 1, 0, 'C');
        $pdf->Cell($larghezza_privacy, $altezze_linea, 'Sos.', 1, 0, 'C');
        $pdf->Cell($larghezza_privacy, $altezze_linea, 'Ass.', 1, 0, 'C');
        $pdf->Cell($larghezza_privacy, $altezze_linea, 'Com.', 1, 0, 'C');
        $pdf->Cell($larghezza_privacy, $altezze_linea, 'Sof.', 1, 0, 'C');
        $pdf->Cell($larghezza_privacy, $altezze_linea, 'Inv.', 1, 0, 'C');
        $pdf->Cell($larghezza_email, $altezze_linea, 'Email', 1, 1, 'C');

        // INSERIMENTO PAZIENTI 

        $lista = Paziente::AllSigned();

        foreach ($lista as $paz) {
            $cognomenome = iconv('UTF-8', 'windows-1252', $paz['cognome']." ".$paz['nome']);
            $data = $paz['data'];
            $privacy_collaboratori = $paz["segreteria"]==1 ? "X" : "-";
            $privacy_sostituti = $paz["sostituti"]==1 ? "X" : "-";
            $privacy_associazione = $paz["associazione"]==1 ? "X" : "-";
            $privacy_commercialista = $paz["consulenti"]==1 ? "X" : "-";
            $privacy_software = $paz["softwarehouse"]==1 ? "X" : "-";
            $privacy_invioricette = $paz["invioricette"]==1 ? "X" : "-";
            $privacy_email = $paz["email"];

            $dt = new \DateTime($data);
            $dt2 = new \DateTime('2020-02-01');
            $dt3 = new \DateTime('2020-08-14');
            if($dt < $dt2) {
                $modello = "#1";
            } else if (($dt >= $dt2) && ($dt < $dt3)) {
                $modello = "#2";
            } else {
                $modello = "#3";
            }            

            $pdf->Cell($larghezza_nome, $altezze_linea, $cognomenome, 1, 0, 'L');
            $pdf->Cell($larghezza_data, $altezze_linea, $data, 1, 0, 'C');
            $pdf->Cell($larghezza_modello, $altezze_linea, $modello, 1, 0, 'C');
            $pdf->Cell($larghezza_privacy, $altezze_linea, $privacy_collaboratori, 1, 0, 'C');
            $pdf->Cell($larghezza_privacy, $altezze_linea, $privacy_sostituti, 1, 0, 'C');
            $pdf->Cell($larghezza_privacy, $altezze_linea, $privacy_associazione, 1, 0, 'C');
            $pdf->Cell($larghezza_privacy, $altezze_linea, $privacy_commercialista, 1, 0, 'C');
            $pdf->Cell($larghezza_privacy, $altezze_linea, $privacy_software, 1, 0, 'C');
            $pdf->Cell($larghezza_privacy, $altezze_linea, $privacy_invioricette, 1, 0, 'C');
            
            $pdf->Cell($larghezza_email, $altezze_linea, $privacy_email, 1, 1, 'L');
        }

        $titolo = "Privacy firmate del " . date("d-m-Y");
        $pdf->SetTitle($titolo);
        $pdf->Output('', $titolo . ".pdf");
        
    }

    public function Cancella($f3, $params)
    {
        $id = $params['id'];
        Paziente::CancellaPrivacyByID($id);

        $f3->reroute('/privacy');
    }
}
