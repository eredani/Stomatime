import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
import DayPicker from 'react-day-picker';
import 'react-day-picker/lib/style.css';
import StarRatingComponent from 'react-star-rating-component';
import {NotificationContainer, NotificationManager} from 'react-notifications';
import 'react-notifications/lib/notifications.css';
if(document.getElementById('medicreact'))
{
    const medicID = window.config.medicID;
    const cabID = window.config.ID;
    const Token = window.config.csrfToken;
    class Doctor extends Component {
        constructor(props){
            super(props);
            this.state ={
                weeks:["duminica","luni","marti","miercuri","joi","vineri","sambata"],
                oreocupate:[],
                time:["05:00","05:30","06:00","06:30","07:00","07:30","08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00","21:30","22:00","22:30"],
                day:null,
                ora:'',
                confirm:false,
                numar:'',
                code:'',
                selectedDay: null,
                DaySelected: null

            };
            this.setNumar = this.setNumar.bind(this);
            this.setCode = this.setCode.bind(this);
            this.sendProgramare = this.sendProgramare.bind(this);
            this.handleDayClick = this.handleDayClick.bind(this);
            this.curentDate=this.curentDate.bind(this);
            this.setProgramare=this.setProgramare.bind(this);
            this.sendConfirm=this.sendConfirm.bind(this);
            
        } 
        sendConfirm()
        {
            if(this.state.code!=='')
            {
                axios.post(`https://stomatime.com/confirmare`,
                { 
                cod: this.state.code,
                id: this.idprogramare,
                id_medic: medicID,
                id_cab: cabID,
                csrfToken: Token 
                }
                )
                .then(res => {
                    switch (res.data.status) {
                        case 'fail': {
                            NotificationManager.error('Error', res.data.msg, 3000);
                            break;
                        }
                        case 'success': {
                            NotificationManager.success('Success', res.data.msg, 3000);
                            this.setState({code:'',confirm:false});
                            this.forceUpdate();
                            break;
                        }
                    }
                })
            }
            else{
                
                NotificationManager.error('Error', "Codul nu este bun.", 3000);
            }
        }
        setCode(e){
            this.setState({code:e.target.value});
        }
        sendProgramare()
        {
            if(this.state.ora!=='' && this.state.numar!=='' && this.state.selectedDay!==null)
            {
                if(this.state.numar.length !== 10)
                {
                    NotificationManager.error('Error', "Numărul trebuie sa fie din 10 cifre.", 3000);
                }
                else
                {
                    axios.post(`https://stomatime.com/programare`,
                    { 
                    nr: this.state.numar,
                    data: this.state.selectedDay,
                    ora: this.state.ora,
                    id_medic: medicID,
                    id_cab: cabID,
                    csrfToken: Token 
                    }
                    )
                    .then(res => {
                        switch (res.data.status) {
                            case 'fail': {
                                NotificationManager.error('Error', res.data.msg, 3000);
                                break;
                            }
                            case 'success': {
                                this.props.update();
                                NotificationManager.success('Success', res.data.msg, 3000);
                                axios.post(`https://stomatime.com/program`,
                                { 
                                  data: this.state.selectedDay,
                                  id_medic: medicID,
                                  id_cab: cabID,
                                  csrfToken: Token 
                                }
                                )
                                .then(res => {
                                    switch (res.data.status) {
                                        case 'fail': {
                                            NotificationManager.error('Error', res.data.msg, 3000);
                                            break;
                                        }
                                        case 'success': {
                                            NotificationManager.success('Success', res.data.msg, 3000);
                                            this.forceUpdate();
                                            break;
                                        }
                                        default:
                                        {
                                            var data=res.data;
                                            this.setState({oreocupate:data});
                                            break;
                                        }
                                    }
                                })
                                this.idprogramare=res.data.id;
                                this.setState({confirm:true});
                                this.forceUpdate();
                                break;
                            }
                        }
                    })
                }
            }
            else
            {
                NotificationManager.error('Error', "Trebuie să completezi tot.", 3000);
            }
        }
        setNumar(e)
        {
            this.setState({numar:e.target.value});
        }
        setProgramare(e)
        {     
            this.setState({ora:e.target.value});
        }
        handleDayClick(day, modifiers = {}) {
            if (modifiers.disabled) {
              return;
            }
           
            this.setState({
              selectedDay: modifiers.selected ? null : day,
            });
            
           if(!modifiers.selected){
                this.setState({
                    DaySelected: day.getDay()
                  });
               
                  axios.post(`https://stomatime.com/program`,
                  { 
                    data: day,
                    id_medic: medicID,
                    id_cab: cabID,
                    csrfToken: Token 
                }
                )
                  .then(res => {
                      switch (res.data.status) {
                          case 'fail': {
                              NotificationManager.error('Error', res.data.msg, 3000);
                              break;
                          }
                          case 'success': {
                              NotificationManager.success('Success', res.data.msg, 3000);
                              this.forceUpdate();
                              break;
                          }
                          default:
                          {
                              var data=res.data;
                              this.setState({oreocupate:data});
                              break;
                          }
                      }
                  })
                }
            
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

            axios.post(`https://stomatime.com/sendscoremedic`,
                { score: scor,
                 medic:medicID,
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
                            this.props.update();
                            NotificationManager.success('Success', res.data.msg, 3000);
                            this.forceUpdate();
                            break;
                        }
                    }

                })
        }
        componentWillMount()
        {
            var date = new Date();
            var day = this.state.weeks[date.getDay()];
            this.setState({day:day});
             
        }
        render()
        {
            var info=this.props.info;
            var orar=[];
            var status;
            var daydisable=[];
            var minDates=null;
            var maxDates=null;
            var timedisable=[];
            var dis=[];
            var opt=[];
            if(this.state.selectedDay!=null && this.state.oreocupate.length>0)
            {
                this.state.oreocupate.forEach(ore=>{
                    dis[ore.ora]=1;
                });
            }
            this.state.weeks.forEach((day,key)=>{
                info.forEach((doctor) => {
                if(doctor.orar!==null)
                {
                if(doctor.orar[day])
                {
                    if(this.state.selectedDay!=null)
                    {
                        opt=[];
                        var zi = this.state.weeks[this.state.selectedDay.getDay()];
                        var minDate=doctor.orar[zi].start;
                        var maxDate=doctor.orar[zi].stop;
                        this.state.time.forEach((ora,c)=>{
                            if(ora>=minDate && ora<=maxDate)
                            {
                                if(dis!=null)
                                {
                                    if(dis[ora+":00"]!=1) 
                                    {
                                        opt.push(<option key={key*Math.random()} value={ora}>{ora}</option>);
                                    }
                                }
                                else
                                {
                                    opt.push(<option key={key*Math.random()} value={ora}>{ora}</option>);
                                }
                            }
                        });
                    }
               
                    orar.push(<div className="col-lg-6 col-md-4 col-sm-4  text-center" key={key}> <p className="text-center"><b>{day.charAt(0).toUpperCase()}{day.slice(1)}: </b>{doctor.orar[day].start}-{doctor.orar[day].stop}</p></div>)
                    
                }
                else
                {
                    daydisable.push(key);
                }
                if(doctor.orar[this.state.day])
                {

                    if(this.curentDate() < doctor.orar[this.state.day].stop  &&  this.curentDate() > doctor.orar[this.state.day].start)
                    {
                        status=(<span className="badge badge-success">Disponibil</span>);
                    }
                    else
                    {
                        status=(<span className="badge badge-danger">Indisponibil</span>);
                    }
                }
                else
                {
                    status=(<span className="badge badge-danger">Indisponibil</span>);
                }
                }
                else
                {
                    status=(<span className="badge badge-danger">Indisponibil</span>);
                }
            });
        });
            var data=[];
            info.forEach((doctor,key)=>{
                var spec=[];
                doctor.specializari.forEach((specializare,index)=>{
                    spec.push(<li className="text-center list-group-item" key={index}>{specializare[0].specializare}</li>)
                });
                if(doctor.descriere!==null && doctor.img_profile!==null && doctor.specializari.length>0 && doctor.orar!==null){
                    data.push(
                    <div key={key} className="col-lg-4 col-md-4 col-sm-6 d-flex text-center">
                        <div className="our-team-main">

                        <div className="team-front">
                        <img src={"https://stomatime.com/"+doctor.img_profile} className="img-fluid" />
                        <h3>{doctor.nume} {doctor.prenume}</h3>
                    <p>{doctor.profesie} </p>
                    <div className="star">
                <StarRatingComponent
                name="rate"
                starCount={5}
                value={doctor.scor}
                onStarClick={this.onStarClick.bind(this)}
                /> 
                </div>
        
                        <div className="cardmedicflow">
                    {doctor.sala.length > 0 && <div>< p className = "text-center" > Cabinetul doctorului < b > {doctor.nume}</b> se afla la etajul <b>{doctor.sala[0].etaj} </b> sala numarul <b>{doctor.sala[0].numar}</b>.</p><hr/></div>}

                        <p className="text-center">
                        {doctor.descriere}
                        </p>
                        </div>
                        <h2>{status}</h2>
                            <div className="row">
                            {orar}
                        </div>
                        </div>
                    </div>
                    </div>
                    );
                }
        });
            var today = new Date();
            var disable = new Date();
            disable.setDate(disable.getDate() + 60);
       
            return(
                <div className="row">
                {data}
                <div className="col-lg-4 col-md-4 col-sm-6 d-flex text-center">
                    <div> 
                        <h4>Selectează ziua in care esti interesat de o programare</h4> <br/> <br/> <br/>
                        <DayPicker
                        selectedDays={this.state.selectedDay}
                        disabledDays={[{ daysOfWeek: daydisable},{after:disable,before: today}]}
                        onDayClick={this.handleDayClick}
                        />
                        {this.state.selectedDay!==null &&
                        <div>
                        <p>Acestea sunt orele disponibile</p>
                        <select className="custom-select" value={this.state.ora} onChange={this.setProgramare}>
                            <option value=""></option>
                            {opt}
                        </select>
                        </div>
                        }
                    </div>
                </div>
                {this.state.selectedDay!==null && this.state.ora!=='' &&
                <div className="col-lg-4 col-md-4 col-sm-6 d-flex text-center">
                    <div>   
                    <h4>Pentru finalizarea te rugam sa introduci un numar de telefon pe care se va face confirmarea</h4>         
                    <br/> <br/> <br/>  
                            <div className="form-group">
                                <label htmlFor="nr">Număr de telefon</label>
                                <input type="number" className="form-control" id="nr" onChange={this.setNumar} value={this.state.numar} aria-describedby="numar" placeholder="Număr de telefon" required/>
                            </div>
                            <button type="submit" onClick={this.sendProgramare} className="btn btn-primary">Programează-te</button>
                    <br/>
                    {this.state.confirm==true &&
                    <div>
                    <div className="form-group">
                                <label htmlFor="cod">Cod de confirmare</label>
                                <input type="number" className="form-control" id="cod" onChange={this.setCode} value={this.state.cod} aria-describedby="cod" placeholder="Cod de confirmare" required/>
                     </div>
                            <button type="submit" onClick={this.sendConfirm} className="btn btn-primary">Confirmă</button>
                   </div> }
                    </div>
                </div>
                }
               </div>
            );
        }
    }
    class Main extends  Component
    {
        constructor(props)
        {
            super(props);
            this.state={
                medic:[],
            }
            this.UpdateData=this.UpdateData.bind(this);
        }
        UpdateData()
        {
            try {
                axios.get(`https://stomatime.com/api/medic/`+ cabID+`/`+medicID)
                    .then(res => {
                        this.setState({
                            medic:res.data
                        });
                    })
            } catch (error) {
                console.log("Eroare la API");
            }
        }
        componentDidMount()
        {
           this.UpdateData();
        }

        render()
        {
            return(
                <div className="container-fluid">
                    <br/>
                    <Doctor info={this.state.medic} update={this.UpdateData}/>
                    <NotificationContainer/>
                </div>
            );
        }
    }
    ReactDOM.render(<Main/>, document.getElementById('medicreact'));
}