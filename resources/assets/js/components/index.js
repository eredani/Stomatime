import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
import StarRatingComponent from 'react-star-rating-component';
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
                <Cards cabinet={cabinet} count={index} key={index}/>
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
                                <h2 className="text-white text-bold mb-2">Do you have a modern clinic?</h2>
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
                                <h2 className="text-white text-bold mb-2">Do you want an efficient and easy to use application?</h2>
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
                                <h2 className="text-white text-bold mb-2">Combine useful with pleasure!</h2>
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
                                <h3>What do we do?&nbsp;
                              <span>How can we help?</span>
                           </h3>
                                <p>StomaTime is a web application for both cabinets and patients</p>
                            </div>
                            <div className="row">
                                <div className="col-sm-6">
                                    <div className="item">
                                        <div className="icon-box">
                                            <figure>
                                                <a href="/cabinet/register" className="btn btn-style-one">Register &nbsp;&nbsp; &nbsp;<span><img src="images/resource/1.png" alt=""/></span></a>
                                            </figure>
                                        </div>
                                        <h6>Cabinets</h6>
                                        <h5>
                                    <b>
                                    <i>Agenda of progammers</i>
                                    </b>- For a good organization.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Patient file</i>
                                    </b>- Easily added data at any time.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Treatment plan</i>
                                    </b>- Well-structured for an efficient consultation.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>E-Mails</i>
                                    </b>- Free to your patients.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Online programming</i>
                                    </b>- Patients who want to be online can be programmed for availability doctor, the appointment being accepted by the cabinet staff.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Fiscalization</i>
                                    </b>- Issuing tax invoices and printing receipts.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Management</i>
                                    </b>- Time schedule, but also the calculation of the percentage of collaborating doctors,viewing personal performance, but also tracking bills.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Reports</i>
                                    </b>- Autocomplete reports, for example: staff activity, progression patients and their observance.
                                 </h5>
                                        <h5>
                                    <b>
                                    <i>Mobility</i>
                                    </b>- Access the app anywhere, anytime to see what you want.
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
                                        <h6>Patients</h6>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>Clinical data</i>
                                       </b>- Everything you want to know about our clinics, doctors, prices, but also services provided by them.
                                    </li>
                                 </h5>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>The doctor's agenda</i>
                                       </b>- It can be easily viewed to see its availability.
                                    </li>
                                 </h5>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>Online scheduling</i>
                                       </b>- You can schedule your own doctor according to availability it.
                                    </li>
                                 </h5>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>SMS-uri/Email-uri</i>
                                       </b>- We notify you by SMS / E-Mail the date and time of your appointment.
                                    </li>
                                 </h5>
                                        <h5>
                                    <li>
                                       <b>
                                       <i>Patient file</i>
                                       </b>- You can access your own folder to see what you've been doing, radiographs, but also the treatment plan established with your doctor your.
                                    </li>
                                 </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button data-toggle="modal" data-target="#info" className="btn btn-style-one">Other information</button>
                        </center>
                        <div className="modal" id="info">
                            <div className="modal-dialog modal-lg">
                                <div className="modal-content">
                                    <div className="modal-header">
                                        <h4 className="modal-title">Other information</h4>
                                        <button type="button" className="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div className="modal-body">
                                        <div className="item">
                                            <center>
                                                <h2>
                                          <b>
                                          <i>Synchronize with your mobile phone</i>
                                          </b>
                                            </h2>
                                                    </center>
                                                    <blockquote>
                                                        <h4>Whether you are using an Iphone, an Android phone, WindowsPhone you can use our application with ease, only with a connection to Internet.<br/>With our application you will always know if a patient wants to reprogram, or if someone wants to come up with an emergency with you.<br/>So you can reorganize even if you are not in the office at the time.
                                            </h4>
                                                    </blockquote>
                                                </div>
                                        <div className="item">
                                            <center>
                                                <h2>
                                            <b>
                                            <i>The doctor's agenda</i>
                                            </b>
                                            </h2>
                                            </center>
                                            <blockquote>
                                            <h4>Managing the agenda can be done by your doctor, nurse, or even the clinic's receptionist, and in the case of online appointments, they will be taken over and approved by cabinet employees.
                                                <br/>When a time delay is busy it will be locked in the agenda will be able to see the times the doctor is available.
                                                <br/>On the agenda, the doctor can also consult the patient's file.<br/>
                                                You can view the calendar by day, week, or even month.
                                            </h4>
                                            </blockquote>
                                            </div>
                                        <div className="item">
                                            <center>
                                            <h2>
                                            <b>
                                            <i>Patient file</i>
                                            </b>
                                            </h2>
                                            </center>
                                            <blockquote>
                                            <h4>
                                            Using StomaTime you have access anywhere and anywhere, with just one internet connections to all your desired data As a physician we always put you at disposition both your agenda and patient file, data about you can look at interventions that have already been performed, or future, radiographs, but also various documents, eg questionnaires filled in by these or various documents that need to be filled in interveţii.<br/>Also, the patient's dossier will also specify how it has arrived either from the recommendation of another patient, or from a friend.
                                            </h4>
                                            </blockquote>
                                            </div>
                                        <div className="item">
                                            <center>
                                            <h2>
                                            <b>
                                            <i>SMS/E-Mails</i>
                                            </b>
                                            </h2>
                                            </center>
                                            <blockquote>
                                            <h4>
                                            Sending SMS to patients will be done automatically at an hour on which you set it up. <br/> So patients are notified the day before the appointment.<br/>
                                                <q>Hello! Tomorrow 1.04.2018, at 12:40, we are waiting for you at the StomaTime clinic.If you can not reach us, please contact us for your convenience reschedule. A nice day!</q>
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
                                <h3>What offers do we have?&nbsp;
                              <span>What do we offer you?</span>
                           </h3>
                                <p>The StomaTime platform is divided into two offers.</p>
                            </div>
                            <div className="row">
                                <div className="col-sm-6">
                                    <div className="item">
                                    <div className="contents">
                                    <div className="section-title">
                                       <h3>Annual</h3>
                                    </div>
                                    <div className="text">
                                       <h4>The annual offer includes the following benefits for € 500 / year.
                                       </h4>
                                    </div>
                                    <ul className="content-list">
                                       <li>
                                          <i className="fa fa-dot-circle-o"></i> Free maintenance and support
                                       </li>
                                       <li>
                                          <i className="fa fa-dot-circle-o"></i> SEO optimization with an unlimited number of keywords
                                       </li>
                                       <li>
                                          <i className="fa fa-dot-circle-o"></i> Take a special page on the platform StomaTime where platform patients can see your office and offers for free for 6 months. Extending this option costs only 5 € / month
                                       </li>
                                       <li>
                                          <i className="fa fa-dot-circle-o"></i> Every new cabinet brought from the side your office gives you a 15% discount on the next one extension.
                                       </li>
                                    </ul>
                                 </div>
                                    </div>
                                </div>
                                <div className="col-sm-6">
                                    <div className="item">
                                        <div className="contents">
                                            <div className="section-title">
                                            <h3>Monthly</h3>
                                            </div>
                                            <div className="text">
                                            <h4>The monthly offer includes the following benefits for the amount of 45 € / month.</h4>
                                            </div>
                                            <ul className="content-list">
                                            <li>
                                                <i className="fa fa-dot-circle-o"></i> Maintenance and free assistance for the first 3 months.
                                            </li>
                                            <li>
                                                <i className="fa fa-dot-circle-o"></i> SEO optimization with a limited number of keywords (10)
                                            </li>
                                            <li>
                                                <i className="fa fa-dot-circle-o"></i> Every new cabinet brought from the side your cabinet offers you a 10% discount on the next one extension.
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
                  <h3>StomaTime	&nbsp;
                     <span>Affiliates</span>
                  </h3>
                  <p>These are some of the affiliated offices with new random extracts from database.
                  </p>
               </div>
               </div>
              

               <div className="row flex-row">
               {row}
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
                        <a href="#despre">About</a>
                     </li>
                     <li>
                        <a href="#oferte">Offers</a>
                     </li>
                        <li>
                        <a href="#aff">Affiliates</a>
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
            <div className="col-lg-3 d-flex">
        <div className="our-cabs-main">

        <div className="team-front"><a href={"/view/"+cabinet.id}>
        <img src={ cabinet.img_profile } className="img-fluid" /></a>
        <a href={"/view/"+cabinet.id}><h3>{cabinet.name}</h3></a>
        <p>{cabinet.adresa}</p>
    <div className="star">
        <StarRatingComponent
        name="{this.props.count}"
        starCount={5}
        value={cabinet.stele}
        />
        <div className="dv-star-rating" style={{display: 'inline-block', position: 'relative'}}>
    <label id="countstars" className="dv-star-rating-star dv-star-rating-empty-star" htmlFor="rate1_5"><i style={{fontStyle: 'normal'}}>({cabinet.voturi})</i></label>
    </div>
    </div>
    <div className="cardmedicflow">
        <p className="text-center"><a href={"/view/"+cabinet.id}>
        Learn more!
    </a>
    </p>
    <hr/>
    <cite className="text-center" title="Source Title">"{cabinet.moto}"</cite>
        <hr/>
        <p>{cabinet.descriere}</p>
    </div>
    </div>
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