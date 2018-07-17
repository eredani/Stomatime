import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
const API = 'https://stomatime.com/api/cabinete/main';
class Header extends Component
{
render(){
    return(
<div className="header-top">
            <div className="container clearfix">
                <div className="top-left">
                    <h2 className="text-dark">StomaTime</h2>
                </div>
                <div className="top-right">
                    <ul className="social-links">
                        <li>
                            <a name="fb" id="fb" href="https://facebook.com/stomatime/">
                                <i className="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a name="tw" id="tw" href="https://twitter.com/stomatime">
                                <i className="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a name="inst" id="inst" href="https://instagram.com/stomatime">
                                <i className="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a name="yt" id="yt" href="https://www.youtube.com/c/stomatime">
                                <i className="fa fa-youtube" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    );
}

}
class SecondPart extends Component{
    constructor(props) {
        super(props);
        this.state = {
          cabinete: []
        };
    }
    componentWillMount()
    {
        axios.get(API)
        .then((res) => {
        this.setState({
            cabinete:res.data
            
        });
      })
 
    }
    render()
    {
        const row = [];
        this.state.cabinete.forEach((cabinet,index)=>
        {
    
            row.push(  
                <Cards cabinet={cabinet} key={index}/>
            )
        })

        return(
            <div className="page-wrapper">
            <div className="hero-slider">
            <div className="slider-item" id="slide1">
                <div className="container">
                    <div className="row">
                        <div className="col-12">
                            <div className="content style text-center">
                                <h2 className="text-white text-bold mb-2">Ai o clinică modernă?</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="slider-item" id="slide2">
                <div className="container">
                    <div className="row">
                        <div className="col-12">
                            <div className="content style text-center">
                                <h2 className="text-white text-bold mb-2">Vrei o aplicație eficientă și ușor de utilizat?</h2>
                                <a href="#" className="btn btn-main btn-white">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="slider-item" id="slide3">
                <div className="container">
                    <div className="row">
                        <div className="col-12">
                            <div className="content style text-center">
                                <h2 className="text-white text-bold mb-2">Îmbină utilul cu plăcutul!</h2>
                                <a href="" className="btn btn-main btn-white">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section className="feature-section section" id="despre">
            <div className="container">
                <div className="row">
                    <div className="col-sm-12 col-xs-12">
                        <div className="image-content">
                            <div className="section-title text-center">
                                <h3>Ce facem noi?
                              <span>Cu ce vă putem ajuta?</span>
                           </h3>
                                <p>StomaTime este o aplicație web atât pentru cabinete cât și pentru pacienți</p>
                            </div>
                            <div className="row">
                                <div className="col-sm-6">
                                    <div className="item">
                                        <div className="icon-box">
                                            <figure>
                                                <a href="/cabinet/register" className="btn btn-style-one">Register &nbsp;&nbsp; &nbsp;<span><img src="images/resource/1.png" alt=""/></span></a>
                                            </figure>
                                        </div>
                                        <h6>Cabinete</h6>
                                        <h5>
                                    <b>
                                    <i>Agenda progrămarilor</i>
                                    </b>
                                    - Pentru o bună organizare.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Dosarul pacientului</i>
                                    </b>
                                    - Datele adăugate cu ușurință disponibile oricând.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Plan de tratament</i>
                                    </b>
                                    - Bine structurat pentru o consultare eficientă.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>SMS-uri/Email-uri</i>
                                    </b>
                                    - Gratuite către pacienții dumneavoastră.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Programari online</i>
                                    </b>
                                    - Pacienții care doresc se pot programa online în funcție de disponibilitatea
                                    medicului, programarea urmând a fi acceptată de personalul cabinetului.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Fiscalizare</i>
                                    </b>
                                    - Emitere facturi fiscale și imprimare chitanțe.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Gestionare</i>
                                    </b>
                                    - Sistem de pontaj, dar și calcularea procentului medicilor colaboratori,
                                    vizualizare performanțe personal, dar și evidența facturilor.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Rapoarte</i>
                                    </b>
                                    - Rapoarte autocompletate, de exemplu: activitatea personalului, progrămarile
                                    pacienților și respectarea acestora.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Mobilitate</i>
                                    </b>
                                    - Acces la aplicație oriunde și oricând pentru a putea consulta datele dorite.
                                 </h5>
                                    </div>
                                </div>
                                <div className="col-sm-6">
                                    <div className="item">
                                        <div className="icon-box">
                                            <figure>
                                                <a href="/register" className="btn btn-style-one">Register &nbsp; &nbsp;&nbsp;<span><img src="images/resource/2.png" alt=""/></span></a>
                                            </figure>
                                        </div>
                                        <h6>Pacienți</h6>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>Date despre clinică</i>
                                       </b>
                                       - Tot ce vreți să aflați despre clinicile noastre, medici, prețuri, dar și
                                       serviciile oferite de acestea.
                                    </li>
                                 </h5>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>Agenda medicului</i>
                                       </b>
                                       - Poate fi consultată cu ușurință pentru a vedea disponibilitatea acestuia.
                                    </li>
                                 </h5>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>Programări online</i>
                                       </b>
                                       - Vă puteți programa singur la medicul dorit în funcție de disponibilitatea
                                       acestuia.
                                    </li>
                                 </h5>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>SMS-uri/Email-uri</i>
                                       </b>
                                       - Vă anunțam prin SMS/Mail data și ora programării.
                                    </li>
                                 </h5>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>Dosarul pacientului</i>
                                       </b>
                                       - Vă puteți accesa singur dosarul pentru a vedea intervențiile efectuate,
                                       radiografii, dar și planul de tratament stabilit împreună cu medicul
                                       dumneavoastră.
                                    </li>
                                 </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button data-toggle="modal" data-target="#info" className="btn btn-style-one">Alte informații</button>
                        </center>
                        <div className="modal" id="info">
                            <div className="modal-dialog modal-lg">
                                <div className="modal-content">
                                    <div className="modal-header">
                                        <h4 className="modal-title">Alte informații</h4>
                                        <button type="button" className="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div className="modal-body">
                                        <div className="item">
                                            <center>
                                                <h2>
                                          <b>
                                          <i>Sincronizarea cu telefonul mobil</i>
                                          </b>
                                            </h2>
                                                    </center>
                                                    <blockquote>
                                                        <h4>Fie că utilizați un Iphone, un telefon cu Android, WindowsPhone puteți
                                                utiliza aplicația noastră cu usurință, doar cu ajutorul unei conexiuni la
                                                internet.<br/>
                                                Cu ajutorul aplicației noastre veți știi mereu dacă un pacient doreste să se
                                                reprogrameze, sau dacă cineva dorește să vină cu o urgență la dumneavoastră.<br/>Astfel
                                                vă puteți reorganiza chiar dacă nu sunteți în cabinet la momentul respectiv.
                                            </h4>
                                                    </blockquote>
                                                </div>
                                        <div className="item">
                                            <center>
                                                <h2>
                                            <b>
                                            <i>Agenda medicului</i>
                                            </b>
                                            </h2>
                                            </center>
                                            <blockquote>
                                            <h4>
                                                Gestionarea agendei se poate face atât de către medic, asistentă, sau chiar
                                                recepționera clinicii, iar în cazul programărilor online, acestea vor fi
                                                preluate și aprobate de angajații cabinetului.
                                                <br/>În momentul în care un înterval orar este ocupat acesta va fi blocat în
                                                agendă astfel se vor putea vedea orele la care medicul este disponibil.
                                                <br/>Tot din agendă medicul poate consulta și dosarul pacientului.<br/>
                                                Vizualizarea agendei se poate face pe zi, săptămână sau chiar luna.
                                            </h4>
                                            </blockquote>
                                            </div>
                                        <div className="item">
                                            <center>
                                            <h2>
                                            <b>
                                            <i>Dosarul pacientului</i>
                                            </b>
                                            </h2>
                                            </center>
                                            <blockquote>
                                            <h4>
                                                Utilizănd StomaTime aveți acces oricănd și oriunde,doar cu ajutorul unei
                                                conexiuni la internet,la toate datele dorite Ca și medic vă punem mereu la
                                                dispoziție atât agenda dumneavoastră cât și dosarul pacienților, date despre
                                                aceștia, puteți consulta intervențiile deja efectuate,sau viitoare,
                                                radiografiile, dar și diverse documente,de exemplu chestionarele completate de
                                                aceștia sau diverse documente care au trebui completate în urma anumitor
                                                interveții.<br/>
                                                De asemenea in dosarul pacientului se va preciza și modul cum acesta a ajuns la
                                                dumneavostră, fie din recomandarea altui pacient, sau a unui prieten.
                                            </h4>
                                            </blockquote>
                                            </div>
                                        <div className="item">
                                            <center>
                                            <h2>
                                            <b>
                                            <i>SMS/Email</i>
                                            </b>
                                            </h2>
                                            </center>
                                            <blockquote>
                                            <h4>
                                                Trimiterea SMS-urilor către pacienți se va face automat la o oră pe care
                                                dumneavoastră o stabiliți.<br/>Astfel pacienții sunt anunțați cu o zi înainte ora programării.<br/>
                                                <q>Bună ziua! Mâine 1.04.2018, la ora 12:40, vă asteptam la clinica StomaTime.
                                                In cazul in care nu puteți ajunge vă rugăm să ne contactați pentru a vă
                                                reprograma. O zi placuta!</q>
                                            </h4>
                                            </blockquote>
                                            </div>
                              
                              
                              
                                            </div>
                                    <div className="modal-footer">
                                        <button type="button" className="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </section>
        <section className="feature-section section " id="oferte">
            <div className="container">
                <div className="row">
                    <div className="col-sm-12 col-xs-12">
                        <div className="image-content">
                            <div className="section-title text-center">
                                <h3>Ce oferte avem?
                              <span>Ce vă oferim?</span>
                           </h3>
                                <p>Platforma StomaTime este împărțită în două oferte.</p>
                            </div>
                            <div className="row">
                                <div className="col-sm-6">
                                    <div className="item">
                                    <div className="contents">
                                    <div className="section-title">
                                       <h3>Anuală</h3>
                                    </div>
                                    <div className="text">
                                       <h4>Oferta anuală cuprinde urmatoarele beneficii pentru suma de 500€/anual.
                                       </h4>
                                    </div>
                                    <ul className="content-list">
                                       <li>
                                          <i className="fa fa-dot-circle-o"></i> Mentenanța și asistență gratuită
                                       </li>
                                       <li>
                                          <i className="fa fa-dot-circle-o"></i> Optimizare SEO cu un număr de keywords nelimitate
                                       </li>
                                       <li>
                                          <i className="fa fa-dot-circle-o"></i> Beneficiați de o pagină specială pe platforma
                                          StomaTime unde pacienți platformei vă pot vedea cabinetul și ofertele gratuit
                                          timp de 6 luni. Prelungirea acestei opțiuni costând doar 5€ / lunar
                                       </li>
                                       <li>
                                          <i className="fa fa-dot-circle-o"></i> La fiecare un nou cabinet adus din partea
                                          cabinetului dumneavoastră vă oferim în plus o reducere de 15% la urmatoarea
                                          prelungire.
                                       </li>
                                    </ul>
                                 </div>
                                    </div>
                                </div>
                                <div className="col-sm-6">
                                    <div className="item">
                                        <div className="contents">
                                            <div className="section-title">
                                            <h3>Lunară</h3>
                                            </div>
                                            <div className="text">
                                            <h4>Oferta lunară cuprinde urmatoarele beneficii pentru suma de 45€ / lună.</h4>
                                            </div>
                                            <ul className="content-list">
                                            <li>
                                                <i className="fa fa-dot-circle-o"></i> Mentenanță și asistența gratuită pentru primele 3 luni.
                                            </li>
                                            <li>
                                                <i className="fa fa-dot-circle-o"></i> Optimizare SEO cu un număr de keywords limitate (10)
                                            </li>
                                            <li>
                                                <i className="fa fa-dot-circle-o"></i> La fiecare un nou cabinet adus din partea
                                                cabinetului dumneavoastră vă oferim în plus o reducere de 10% la urmatoarea
                                                prelungire.
                                            </li>
                                            </ul>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                     </div>
                  </div>
               </div>       
        </section>
        <section className="service-section section" id="aff">
            <div className="container">
               <div className="section-title text-center">
                  <h3>StomaTime
                     <span>Afiliați</span>
                  </h3>
                  <p>Acestea sunt unele dintre cabinetele afiliate cu noi extrase aleator din
                     baza de date.
                  </p>
               </div>
               </div>
              
            <div className="container">
               <div className="row flex-row">
               {row}
               </div>
            </div>
        </section>
              
        <footer className="footer-main">
            <div className="footer-bottom">
               <div className="container clearfix">
                  <div className="copyright-text">
                     <p>&copy; Copyright 2018. All Rights Reserved by&nbsp;
                        <a href="/">StomaTime</a>
                     </p>
                  </div>
                  <ul className="footer-bottom-link">
                     <li>
                        <a href="/">Home</a>
                     </li>
                     <li>
                        <a href="#despre">Despre</a>
                     </li>
                     <li>
                        <a href="#oferte">Oferte</a>
                     </li>
                  </ul>
               </div>
            </div>
         </footer>
        </div> 
        );
    }
} 
class Cards extends Component{
    render()
    {
        const cabinet = this.props.cabinet;
        return(
            <div className="col- col-md-6 col-lg-4 col-xl-4 col-sm-6  d-md-flex d-sm-flex d-lg-flex d-xl-flex">
            <div className="card mt-3 p-2 flex-sm-fill flex-md-fill flex-lg-fill flex-xl-fill text-center d-md-flex d-sm-flex d-lg-flex d-xl-flex" width="20rem">
                {
                cabinet.img_profile!=null
                ?
                <a href={"/view/"+cabinet.id}>
                  <img
                    src={ cabinet.img_profile }
                    alt="Aici vine o poza pusa de cabinet"
                    className="card-img-top"
                    width="200px" height="200px"/>
                    </a> 
                :
                <a href={"/view/"+cabinet.id}>
                    <img src="/storage/logo.png" alt="Aici vine o poza pusa de cabinet"  className="card-img-top"  width="200px" height="200px"/>
                </a> 
                }
                <div className="card-body flex-sm-fill flex-md-fill flex-lg-fill flex-xl-fill ">
                <hr/>
                   <a className="card-text"  href={"/view/"+cabinet.id}>
                       <h6 className="card-title">{cabinet.name}</h6>
                    </a> 
                    <hr/>
                    {
                        cabinet.moto!=null
                        ?
                        <div>
                         <cite title="Source Title">"{cabinet.moto}"</cite>
                        <hr/>
                      
                        </div>
                        :
                        <br/>
                    }
                    {
                        cabinet.descriere!=null
                        ?
                        <p className="card-text">{cabinet.descriere}</p>
                        :
                        <br/>
                    }                   
                </div>
                {
                    cabinet.adresa!=null
                    ?
                    <div className="card-footer text-muted flex-sm-fill flex-md-fill flex-lg-fill flex-xl-fill ">
                    <p className="card-text">{cabinet.adresa} <br/>{cabinet.numar!=null ?  ' Contact: '+ cabinet.numar:<br/>}</p>
                </div>
                    :
                    <br/>
                }
            </div>
            </div>
        );
    }
}
if(document.getElementById('htop'))
{
    ReactDOM.render(<Header/>, document.getElementById('htop'));
}
if(document.getElementById('secpart'))
{
    ReactDOM.render(<SecondPart/>, document.getElementById('secpart'));
}