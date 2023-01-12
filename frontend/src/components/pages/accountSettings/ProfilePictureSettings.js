import React, { useRef, useState, useEffect } from "react";
import SideBar_AccountSettings from './SideBar_AccountSettings'; 
import { withTokenRequest, requestHeaders } from '../../../http';
import Uploady from "@rpldy/uploady";
import UploadButton from "@rpldy/upload-button";
import UploadPreview from "@rpldy/upload-preview";
import "../../modules/crop/Crop.css";
import "../../modules/crop/CropImage";
import noImage from "../../../assets/img/no image/noimage.png"
import { deleteBackSlash } from "../../../utils/function";
import { ItemPreviewWithCrop } from "../../modules/crop/CropImage";

const ProfilePictureSettings = () => {
    const previewMethodsRef = useRef();
    const [profilePicutreCropped1Pass, setProfilePictureCropped1Pass] = useState(null);
    const [profilePicutreCropped2Pass, setProfilePictureCropped2Pass] = useState(null);
    const [profilePicutreCropped3Pass, setProfilePictureCropped3Pass] = useState(null);
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    const date= Date.now();

    useEffect(() => {
        getProfilePictureCropped();
    }, []);

    function getProfilePictureCropped() {
        withTokenRequest.post('./getProfilePictureCropped', {user_id: localStorage.getItem('user_id')},
            {headers: requestHeaders}
        )
        .then((res) => {
            if (!res.data.data.profilePictureCropped1) {
                setProfilePictureCropped1Pass(noImage);
            } else {
                setProfilePictureCropped1Pass('../../storage/' + deleteBackSlash(res.data.data.profilePictureCropped1));
            }
            if (!res.data.data.profilePictureCropped2) {
                setProfilePictureCropped2Pass(noImage);
            } else {
                setProfilePictureCropped2Pass('../../storage/' + deleteBackSlash(res.data.data.profilePictureCropped2));
            }
            if (!res.data.data.profilePictureCropped3) {
                setProfilePictureCropped3Pass(noImage);
            } else {
                setProfilePictureCropped3Pass('../../storage/' + deleteBackSlash(res.data.data.profilePictureCropped3));
            }
        });
    }

    function deleteProfilePicture(profilePictureNo) {
        withTokenRequest.post('./deleteProfilePicture', {user_id: localStorage.getItem('user_id'), profilePictureNo: profilePictureNo},
            {headers: requestHeaders}
        )
        .then(() => {
            switch (profilePictureNo) {
                case 1:
                    setProfilePictureCropped1Pass(noImage);
                    break;
                case 2:
                    setProfilePictureCropped2Pass(noImage);
                    break;
                case 3:
                    setProfilePictureCropped3Pass(noImage);
                    break;
            }
        })
    }

    /** css */
    const mainContents = {
        float: 'left',
        margin: '10px',
        width: 'calc(100% - 362px)'
    }

    const profilePictureSettings = {
        float: 'left',
        margin: '10px',
        padding: '10px',
    }

    const croppedStyle = {
        width: '200px',
        height: '200px'
    }

    const deleteButtonStyle = {
        'margin-left': '50px'
    }

    return (
        <>
            <SideBar_AccountSettings />
            <div style={mainContents}>
                <Uploady
                    multiple={false}
                >
                    <div className="ProfilePicture1" style={profilePictureSettings}>
                        <img src={profilePicutreCropped1Pass + "?" + date} alt="picture" style={croppedStyle}></img><br></br>
                        <UploadButton>SETTINGS</UploadButton>
                        <button style={deleteButtonStyle} onClick={() => deleteProfilePicture(1)}>DELETE</button>
                        <br />
                    <UploadPreview
                        PreviewComponent={ItemPreviewWithCrop}
                        previewComponentProps={{ 
                            previewMethods: previewMethodsRef, aspectProps: 1 / 1, api: 'setProfilePicture', 
                            aspectControllButtonsVisible: false, inputTextVisible: false,
                            distinctiveParam: {profilePictureNo: 1, distinctiveFunc: getProfilePictureCropped}
                        }}
                        previewMethodsRef={previewMethodsRef}
                    />
                    </div>
                </Uploady>
                <Uploady
                    multiple={false}
                >
                    <div className="ProfilePicture2" style={profilePictureSettings}>
                        <img src={profilePicutreCropped2Pass + "?" + date} alt="picture" style={croppedStyle}></img><br></br>
                        <UploadButton>SETTINGS</UploadButton>
                        <button style={deleteButtonStyle} onClick={() => deleteProfilePicture(2)}>DELETE</button>
                        <br />
                    <UploadPreview
                        PreviewComponent={ItemPreviewWithCrop}
                        previewComponentProps={{ 
                            previewMethods: previewMethodsRef, aspectProps: 1 / 1, api: 'setProfilePicture', 
                            aspectControllButtonsVisible: false, inputTextVisible: false,
                            distinctiveParam: {profilePictureNo: 2, distinctiveFunc: getProfilePictureCropped}
                        }}
                        previewMethodsRef={previewMethodsRef}
                    />
                    </div>
                </Uploady>
                <Uploady
                    multiple={false}
                >
                    <div className="ProfilePicture3" style={profilePictureSettings}>
                        <img src={profilePicutreCropped3Pass + "?" + date} alt="picture" style={croppedStyle}></img><br></br>
                        <UploadButton>SETTINGS</UploadButton>
                        <button style={deleteButtonStyle} onClick={() => deleteProfilePicture(3)}>DELETE</button>
                        <br />
                    <UploadPreview
                        PreviewComponent={ItemPreviewWithCrop}
                        previewComponentProps={{ 
                            previewMethods: previewMethodsRef, aspectProps: 1 / 1, api: 'setProfilePicture', 
                            aspectControllButtonsVisible: false, inputTextVisible: false,
                            distinctiveParam: {profilePictureNo: 3, distinctiveFunc: getProfilePictureCropped}
                        }}
                        previewMethodsRef={previewMethodsRef}
                    />
                    </div>
                </Uploady>
            </div>
        </>
    );
}

export default ProfilePictureSettings;

