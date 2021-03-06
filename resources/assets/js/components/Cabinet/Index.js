import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
import StarRatingComponent from 'react-star-rating-component';
import {NotificationContainer, NotificationManager} from 'react-notifications';
import 'react-notifications/lib/notifications.css';
import {withGoogleMap,GoogleMap,Marker} from "react-google-maps";
if(document.getElementById('reactview'))
{
    const cabID = window.config.ID;
    const Token = window.config.csrfToken;
    class SectionCards extends Component{
        constructor(props) {
            super(props);    
            this.state ={
                weeks:["duminica","luni","marti","miercuri","joi","vineri","sambata"],
                day:null
            };
            this.curentDate=this.curentDate.bind(this);
        }
        componentWillMount(){
            var date = new Date();
            var day = this.state.weeks[date.getDay()];
            this.setState({day:day});
        }
        curentDate() {
            var date = new Date();
            var ora = date.getHours();
            var minute = date.getMinutes();
            ora = ora % 24;
            ora = ora ? ora : 0;
            ora = ora < 10 ? '0'+ora : ora;
            minute = minute < 10 ? '0'+minute : minute;
            var time = ora + ':' + minute;
            return time;
        }
        onStarClick(nextValue, prevValue, name) {

            var scor = nextValue;

            axios.post(`https://stomatime.com/sendscore`,
                { score: scor,
                cabinet: cabID,
                csrfToken:Token }
                )
                .then(res => {
                    switch (res.data.status) {
                        case 'fail': {

                            NotificationManager.error('Error', res.data.msg, 3000);
                            break;
                        }
                        case 'success': {
                            this.props.updateData();
                            NotificationManager.success('Success', res.data.msg, 3000);
                            this.forceUpdate();
                            break;
                        }
                            break;
                    }

                })
        }
        render() {
            var cabinetul=[];
            var medicrandom=[];
            var orar=[];
            var status;
            this.state.weeks.forEach((day,key)=>{
            this.props.cabinet.forEach((cab) => {
                cabinetul=cab;
                if(cabinetul.countdoctori>0)
                    medicrandom=cab.doctori[Math.floor(Math.random() * cabinetul.countdoctori)];
                else
                    medicrandom=null;
                if(cab.program!==null)
                {
                if(cab.program[day])
                {
                    orar.push(<div className="col-lg-6 col-md-4 col-sm-4  text-center" key={key}> <p className="text-center"><b>{day.charAt(0).toUpperCase()}{day.slice(1)}: </b>{cab.program[day].start}-{cab.program[day].stop}</p></div>)
                }
                if(cab.program[this.state.day])
                {

                    if(this.curentDate() < cab.program[this.state.day].stop  &&  this.curentDate() > cab.program[this.state.day].start)
                    {
                        status=(<span className="badge badge-success">Open</span>);
                    }
                    else
                    {
                        status=(<span className="badge badge-danger">Closed</span>);
                    }
                }
                else
                {
                    status=(<span className="badge badge-danger">Closed</span>);
                }
                }
                else
                {
                    status=(<span className="badge badge-danger">Closed</span>);
                }

            });
        });
            return(
            <div className="row">
            <div  className="col-lg-4 col-md-4 col-sm-6 d-flex text-center">
                    <div className="our-team-main">

                    <div className="team-front">
                    <h2>{status}</h2>
                    <div className="row">
                    {orar}
                    </div>
                    <div className="star">
                <StarRatingComponent
            name="rate"
            starCount={5}
            value={cabinetul.scor}
            onStarClick={this.onStarClick.bind(this)}
            />
            </div>
                    </div>
                    </div>
                </div>
                        
                        <div  className="col-lg-4 col-md-4 col-sm-6 d-flex text-center">
                        <div className="our-team-main">
        
                        <div className="team-front"> 
                        <h2>Contact</h2>
                        <div className="card-text cardflow text-center"><h5><i className="fa">&#xf003;</i>  {cabinetul.email}</h5><br/> <h5>{cabinetul.numar!==null ?  <i  className="fa">&#xf2a0; {cabinetul.numar}</i> : ""}</h5></div>
                            <h5 className="card-text text-center"><small ><i className="fa">&#xf041;</i> {cabinetul.adresa}</small></h5>
                        
                        </div>
                    </div>
                    </div>
                    <div  className="col-lg-4 col-md-4 col-sm-6 d-flex text-center">
                        <div className="our-team-main">
        
                        <div className="team-front">
                        <h2>Info</h2>
                        {
                        medicrandom!==null
                        ?
                        <div>
                            <div className="text-center cardflow"><h5>Team {cabinetul.name} is composed of {cabinetul.countdoctori} experienced doctors in various specializations.</h5></div>

                    <p className = " text-center" > <small>Doctor highlighted &nbsp;
                    <a href={"https://stomatime.com/view/"+window.config.ID+"/medic/"+medicrandom.id}>
                        {medicrandom.nume} {medicrandom.prenume}
                    </a>
                    </small>
                    </p>
                    </div>
                    : ""
                    }
                        
                        </div>
                    </div>
                    </div>
            </div>
            );
        }
    }
    class ToolServiciiSpecializari extends  Component{
        constructor(props) {
            super(props);

        }
        render(){

            return(

                    <div className="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <div className="card">
                            <div className={"card-block block-"+this.props.index}>
                            <h3 className="card-title text-center">{this.props.spec.specializare}</h3>
                            </div>
                        </div>
                    </div>

            );
        }
    }
    class SectionSpecializari extends  Component{
        constructor(props) {
            super(props);

        }
        render()
        {
            var specializari={};
            var card=[];
            var moto=null;
            this.props.cabinet.forEach(data=>{
                moto=data.moto;
                data.specializari.forEach((specializare,key)=>{

                    if(key<6){
                        card.push(<ToolServiciiSpecializari key={key} index={key+1} spec={specializare}/>);
                    }
                });

            });


            return(
                <section id="what-we-do">
                    <div className="container-fluid">
                    <h2 className="section-title mb-2 h1">Specializations available</h2>
                    <p className="text-center text-muted h5">{moto}</p>
            <div className="row mt-5">
            {card}

            </div>
            <p className="text-center"><a className="text-muted h5" href={"https://stomatime.com/view/"+window.config.ID+"/servicii"}>See more specializations and details about them</a></p>
            <h2 className="section-title mb-2 h1">Doctors</h2>
            </div>
            </section>
        );
        }
    }
    class SectionPersonal extends  Component{
        render() {
            var medici=[];
            this.props.cabinet.forEach(cab=>{
            cab.doctori.forEach((doctor,key)=>{
                var spec=[];
                doctor.specializari.forEach((specializare,index)=>{
                    spec.push(<li className="text-center list-group-item" key={index}>{specializare[0].specializare}</li>)
            });
                if(doctor.descriere!==null && doctor.img_profile!==null && doctor.specializari.length>0 && doctor.orar!==null){
                    medici.push(
                    <div key={key} className="col-lg-3 col-md-4 col-sm-6 d-flex">
                        <div className="our-team-main">

                        <div className="team-front">
                        <a href={"https://stomatime.com/view/"+window.config.ID+"/medic/"+doctor.id}><img src={"https://stomatime.com/"+doctor.img_profile} className="img-fluid" /></a>
                        <a href={"https://stomatime.com/view/"+window.config.ID+"/medic/"+doctor.id}><h3>{doctor.nume} {doctor.prenume}</h3></a>
                    <p>{doctor.profesie} </p>
                    </div>
                    <div className="star">
                        <StarRatingComponent
                        name={"medic"+doctor.id}
                        starCount={5} 
                        value={doctor.stele}
                        />

                    <div className="dv-star-rating" style={{display: 'inline-block', position: 'relative'}}>
                        <label id="countstars" className="dv-star-rating-star dv-star-rating-empty-star" htmlFor={"medic"+doctor.id}><i style={{fontStyle: 'normal'}}>({doctor.voturi})</i></label>
                    </div>
                    </div>
                    <div className="team-back">
                        <div className="cardmedicflow">
                        <p className="text-center"><a href={"https://stomatime.com/view/"+window.config.ID+"/medic/"+doctor.id}>
                        Make your appointment.
                    </a></p>
                    {doctor.sala.length > 0 && <div>< p className = "text-center" > Cabinet doctor < b > {doctor.nume}</b> is on the floor <b>{doctor.sala[0].etaj} </b> hall number <b>{doctor.sala[0].numar}</b>.</p><hr/></div>}

                        <p className="text-center">
                        {doctor.descriere}
                        </p>
                        </div>
                    </div>
                    </div>
                    </div>
                    );
                }

            });
        });
            return (
                <div className="container-fluid">

                <div className="row">
                {medici}


            </div>
            </div>
            );
        }
    }
    class Map extends Component {
        constructor(props) {
            super(props);
        }
        render()
        {
            const GoogleMapExample = withGoogleMap(props => (
                <GoogleMap
            defaultCenter = { { lat: parseFloat(this.props.lat), lng: parseFloat(this.props.long) } }
            defaultZoom = { 15 }>
                <Marker position={{ lat: parseFloat(this.props.lat), lng: parseFloat(this.props.long) }} />
                </GoogleMap>
        ));
            return(
                <div>
                <GoogleMapExample
            containerElement={ <div id="map-container" style={{ height: `240px`, width: '100%' }} /> }
            mapElement={ <div style={{ height: `100%` }} /> }
            />
            </div>
        );
        }
    }
    class Footer extends  Component{
        render(){
            var today = new Date();
            var year = today.getFullYear();
            var lat,long,name;
            this.props.cabinet.forEach(data=>{
            lat=data.lat;
            long=data.long;
            name=data.name;
            });
            return(
                <footer id="myFooter">
                <div className="container">
                {
                lat!==null?
                < Map
                lat = {lat}
                long = {long}
                />
                :
                ""
                }
                </div>
                <div className="footer-copyright">
                    <p>© {year} Copyright {name} </p>
                </div>
                </footer>
            );
        }
    }
    class Main extends Component {
        constructor(props) {
            super(props);    
            this.state ={
                cabinet:[],
            };
            this.UpdateData=this.UpdateData.bind(this);
        }
        UpdateData()
        {
            try {
                axios.get(`https://stomatime.com/api/cabinete/`+ window.config.ID)
                    .then(res => {
                        this.setState({
                            cabinet:res.data
                        });
                    })
            } catch (error) {
                console.log("API error");
            }
        }
        componentDidMount(){
            this.interval = setInterval(() => this.UpdateData(), 60000);
               this.UpdateData();
        }
        componentWillUnmount() {
            clearInterval(this.interval);
        }
        render()
    {
        return(
            <div>
            <SectionCards updateData={this.UpdateData} cabinet={this.state.cabinet}/>
            <SectionSpecializari cabinet={this.state.cabinet}/>
            <SectionPersonal cabinet={this.state.cabinet}/>
            <Footer cabinet={this.state.cabinet}/>
            <NotificationContainer/>
        </div>
        );
        }
    }
    ReactDOM.render(<Main/>, document.getElementById('reactview'));
}

