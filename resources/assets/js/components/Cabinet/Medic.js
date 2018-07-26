import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
if(document.getElementById('medicreact'))
{
    const medicID = window.config.medicID;
    const cabID = window.config.ID;
    class Main extends  Component
    {
        constructor(props)
        {
            super(props);
            this.state={
                medic:[]
            }
        }
        componentWillMount()
        {
            /*try {
                axios.get(`https://stomatime.com/api/medic/`+ cabID+`/`+medicID)
                    .then(res => {
                        this.setState({
                            medic:res.data
                        });
                    })
            } catch (error) {
                console.log("Eroare la API");
            }*/
        }

        render()
        {
            return(
                <h1>Aici o sa fie detalii despre doctorul selectat cat si posibilitatea de a face o programare.</h1>
            );
        }
    }
    ReactDOM.render(<Main/>, document.getElementById('medicreact'));
}