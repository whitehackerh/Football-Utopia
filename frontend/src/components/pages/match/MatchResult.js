import React from 'react';
import yes from "../../../assets/img/matchResult/yes.png";
import nope from "../../../assets/img/matchResult/nope.png";
import match from "../../../assets/img/matchResult/match.png";

const MatchResult = (props) => {
    const resultImageStyle = {
        width: '150px',
        height: 'auto'
    };

    let yesOrMatch = '';
    if (props.is_match) {
        yesOrMatch = (
                <img src={match} style={resultImageStyle}></img>
            );
    } else {
        yesOrMatch = (
                <img src={yes} style={resultImageStyle}></img>
            );
    }

    return (
        <div>
            {props.action == 0 ? (
                yesOrMatch
            ) : (
                <img src={nope} style={resultImageStyle}></img>
            )}
        </div>
    )
}

export default MatchResult;
