VERSION 5.00
Begin VB.Form Form1 
   Appearance      =   0  'Flat
   BackColor       =   &H80000005&
   BorderStyle     =   0  'None
   Caption         =   "Form1"
   ClientHeight    =   6000
   ClientLeft      =   0
   ClientTop       =   0
   ClientWidth     =   9600
   ControlBox      =   0   'False
   Icon            =   "Form1.frx":0000
   LinkTopic       =   "Form1"
   MinButton       =   0   'False
   ScaleHeight     =   400
   ScaleMode       =   3  'Pixel
   ScaleWidth      =   640
   ShowInTaskbar   =   0   'False
   StartUpPosition =   2  'ÆÁÄ»ÖÐÐÄ
   Visible         =   0   'False
   Begin VB.Timer AutoTimer 
      Interval        =   1000
      Left            =   8520
      Top             =   4200
   End
   Begin VB.Timer Timer1 
      Interval        =   800
      Left            =   4560
      Top             =   2760
   End
   Begin VB.Label statusText 
      Alignment       =   2  'Center
      BackColor       =   &H00000000&
      Caption         =   "oExam"
      BeginProperty Font 
         Name            =   "ËÎÌå"
         Size            =   10.5
         Charset         =   134
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FFFFFF&
      Height          =   255
      Left            =   1920
      TabIndex        =   0
      Top             =   5280
      Width           =   5655
   End
End
Attribute VB_Name = "Form1"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Explicit

Private updateUrl As String
Private updateKeyLocal As String
Private updateKeyRemote As String
Private updateFileAttempt As Integer
Private updateFileReady As Boolean
Private updateFileDone As Boolean
Private iCount As Integer
Private timeoutSec As Integer

Private Declare Function WritePrivateProfileString Lib "kernel32" _
Alias "WritePrivateProfileStringA" _
                        (ByVal lpApplicationName As String, _
                        ByVal lpKeyName As Any, _
                        ByVal lpString As Any, _
                        ByVal lpFileName As String) As Long

Private Declare Function GetPrivateProfileString Lib "kernel32" _
Alias "GetPrivateProfileStringA" _
                        (ByVal lpApplicationName As String, _
                        ByVal lpKeyName As Any, _
                        ByVal lpDefault As String, _
                        ByVal lpReturnedString As String, _
                        ByVal nSize As Long, _
                        ByVal lpFileName As String) As Long






Private Declare Function URLDownloadToFile Lib "urlmon" _
   Alias "URLDownloadToFileA" _
  (ByVal pCaller As Long, _
   ByVal szURL As String, _
   ByVal szFileName As String, _
   ByVal dwReserved As Long, _
   ByVal lpfnCB As Long) As Long

Private Const ERROR_SUCCESS As Long = 0
Private Const BINDF_GETNEWESTVERSION As Long = 0









Private Const WAIT_INFINITE = -1&
Private Const SYNCHRONIZE = &H100000

Private Declare Function OpenProcess Lib "kernel32" _
  (ByVal dwDesiredAccess As Long, _
   ByVal bInheritHandle As Long, _
   ByVal dwProcessId As Long) As Long
   
Private Declare Function WaitForSingleObject Lib "kernel32" _
  (ByVal hHandle As Long, _
   ByVal dwMilliseconds As Long) As Long
   
Private Declare Function CloseHandle Lib "kernel32" _
  (ByVal hObject As Long) As Long







    

 
Private Declare Function EnumProcesses Lib "PSAPI.DLL" ( _
   lpidProcess As Long, ByVal cb As Long, cbNeeded As Long) As Long
 
Private Declare Function EnumProcessModules Lib "PSAPI.DLL" ( _
    ByVal hProcess As Long, lphModule As Long, ByVal cb As Long, lpcbNeeded As Long) As Long
 
Private Declare Function GetModuleBaseName Lib "PSAPI.DLL" Alias "GetModuleBaseNameA" ( _
    ByVal hProcess As Long, ByVal hModule As Long, ByVal lpFileName As String, ByVal nSize As Long) As Long
 
Private Const PROCESS_VM_READ = &H10
Private Const PROCESS_QUERY_INFORMATION = &H400









Private Const HWND_TOPMOST = -1
Private Const HWND_NOTOPMOST = -2
Private Const SWP_NOMOVE = &H2
Private Const SWP_NOSIZE = &H1
Private Const SWP_NOACTIVATE = &H10
Private Const SWP_SHOWWINDOW = &H40
Private Const FLAGS = SWP_NOMOVE Or SWP_NOSIZE

Private Declare Function SetWindowPos Lib "user32" _
   (ByVal hwnd As Long, ByVal hWndInsertAfter As Long, _
    ByVal x As Long, ByVal y As Long, _
    ByVal cx As Long, ByVal cy As Long, _
    ByVal wFlags As Long) As Long







 
Private Function IsProcessRunning(ByVal sProcess As String) As Boolean
    Const MAX_PATH As Long = 260
    Dim lProcesses() As Long, lModules() As Long, N As Long, lRet As Long, hProcess As Long
    Dim sName As String
    Dim iCnt As Integer
    
    sProcess = UCase$(sProcess)
    iCnt = 0
    
    ReDim lProcesses(1023) As Long
    If EnumProcesses(lProcesses(0), 1024 * 4, lRet) Then
        For N = 0 To (lRet \ 4) - 1
            hProcess = OpenProcess(PROCESS_QUERY_INFORMATION Or PROCESS_VM_READ, 0, lProcesses(N))
            If hProcess Then
                ReDim lModules(1023)
                If EnumProcessModules(hProcess, lModules(0), 1024 * 4, lRet) Then
                    sName = String$(MAX_PATH, vbNullChar)
                    GetModuleBaseName hProcess, lModules(0), sName, MAX_PATH
                    sName = Left$(sName, InStr(sName, vbNullChar) - 1)
                    If Len(sName) = Len(sProcess) Then
                        If sProcess = UCase$(sName) Then
                            IsProcessRunning = True
                            ' Exit Function
                            iCnt = iCnt + 1
                            IsProcessRunning = iCnt > 1
                        End If
                    End If
                End If
            End If
            CloseHandle hProcess
        Next N
    End If
End Function

Private Function DownloadFile(sSourceUrl As String, _
                             sLocalFile As String) As Boolean

   DownloadFile = URLDownloadToFile(0&, _
                                    sSourceUrl, _
                                    sLocalFile, _
                                    BINDF_GETNEWESTVERSION, _
                                    0&) = ERROR_SUCCESS

End Function






                        
Public Function INIWrite(sSection As String, sKeyName As String, sNewString As String, sINIFileName As String) As Boolean
  
  Call WritePrivateProfileString(sSection, sKeyName, sNewString, sINIFileName)
  INIWrite = (Err.Number = 0)
End Function

Public Function INIRead(sSection As String, sKeyName As String, sINIFileName As String) As String
    Dim sRet As String

  sRet = String(255, Chr(0))
  INIRead = Left(sRet, GetPrivateProfileString(sSection, ByVal sKeyName, "", sRet, Len(sRet), sINIFileName))
End Function










Private Function GetHTMLSource(ByVal sURL As String) As String
    Dim xmlHttp As Object
    Set xmlHttp = CreateObject("MSXML2.XmlHttp")
    xmlHttp.Open "post", sURL, False
    xmlHttp.setRequestHeader "If-None-­ Match", "some-random-string"
    xmlHttp.setRequestHeader "Cache-Co­ ntrol", "no-cache,max-age=0"
    xmlHttp.setRequestHeader "Pragma", "no-cache"
    xmlHttp.send
    GetHTMLSource = xmlHttp.responseText
    Set xmlHttp = Nothing
End Function

Private Sub AutoTimer_Timer()
    iCount = iCount + 1
    If iCount >= timeoutSec Then
        Call INIWrite("splash", "update_key", "NULL", App.Path & "\configuration.ini")
        Unload Me
    End If
End Sub

Private Sub Form_Load()
    On Error Resume Next
    
    If IsProcessRunning("oExamClient.exe") Then
        'MsgBox "unload me"
        Unload Me
        Exit Sub
    End If
    
    Me.Visible = True
    Call SetWindowPos(Me.hwnd, HWND_TOPMOST, 0, 0, 0, 0, FLAGS)

    Me.Picture = LoadPicture(App.Path & "\" & INIRead("splash", "splash_img", App.Path & "\configuration.ini"))
    
    updateUrl = ""
    updateKeyLocal = INIRead("splash", "update_key", App.Path & "\configuration.ini")
    updateKeyRemote = ""
    updateFileAttempt = 0
    updateFileReady = False
    updateFileDone = False
    iCount = 0
    timeoutSec = INIRead("splash", "timeout_ss", App.Path & "\configuration.ini")
End Sub

Private Sub Timer1_Timer()

    On Error GoTo ErrorHandler
    Dim isExtractNow As Boolean
    isExtractNow = False
    
    If updateFileDone Then
        Me.statusText.Caption = "Ö÷³ÌÐò¼ÓÔØÖÐ£¬ÇëÉÔºò¡­¡­"
        Call INIWrite("splash", "update_key", IIf(Len(updateKeyRemote) > 20, "NULL", updateKeyRemote), App.Path & "\configuration.ini")
        If isExtractNow Then
            Call INIWrite("splash", "update_key", "NULL", App.Path & "\configuration.ini")
        End If
        Call StartExam
    ElseIf Len(updateUrl) = 0 Then
        updateUrl = INIRead("splash", "update_url", App.Path & "\configuration.ini")
        Me.statusText.Caption = "¼ì²é¸üÐÂÖÐ¡­¡­" & updateUrl
    ElseIf Len(updateKeyRemote) = 0 Then
        updateKeyRemote = GetHTMLSource(updateUrl)
        If Replace(updateKeyRemote, ".7z", "") = updateKeyRemote Then
            Me.statusText.Caption = "ÔÝÊ±ÎÞ·¨È¡µÃÔ¶³Ì¸üÐÂÐÅÏ¢"
            updateFileReady = True
            updateFileDone = True
        ElseIf updateKeyRemote = updateKeyLocal Then
            Me.statusText.Caption = "µ±Ç°°æ±¾Îª×îÐÂÄÚÈÝ"
            updateFileReady = True
            updateFileDone = True
        End If
    ElseIf Not updateFileReady And updateKeyRemote <> updateKeyLocal Then
        Me.statusText.Caption = "ÎÄ¼þÏÂÔØÖÐ¡­¡­" & updateKeyRemote
        updateFileAttempt = updateFileAttempt + 1
        If DownloadFile(updateUrl & "/" & updateKeyRemote, App.Path & "\\" & updateKeyRemote) Then
            Me.statusText.Caption = "ÎÄ¼þÏÂÔØ³É¹¦¡­¡­" & updateKeyRemote
            updateFileReady = True
        Else
            Me.statusText.Caption = "ÎÄ¼þÏÂÔØÊ§°Ü¡­¡­" & updateKeyRemote
            updateFileDone = True
            Call StartExam
        End If
    ElseIf Not updateFileDone And updateFileReady Then
        ' Extract new 7z file
        isExtractNow = True
        
        Dim hProcess As Long
        Dim taskId As Long
        Dim cmd As String
        cmd = """" & App.Path & "\7za.exe"" x -y -o""" & App.Path & """ """ & App.Path & "\" & updateKeyRemote & """"
        taskId = Shell(cmd, vbHide)
        hProcess = OpenProcess(SYNCHRONIZE, True, taskId)
        Call WaitForSingleObject(hProcess, WAIT_INFINITE)
        'CloseHandle hProcess

        If Dir(App.Path & "\" & updateKeyRemote & ".readme") = "" Then
            Err.Raise 29000, "error"
        End If
        
        updateFileDone = True
        Me.statusText.Caption = "ÎÄ¼þ¸üÐÂÍê³É¡­¡­" & updateKeyRemote
        
        isExtractNow = False
    End If
    
    'If IsProcessRunning("oExamMain.exe") Then
    '    Unload Me
    'End If
    
    Exit Sub

ErrorHandler:
    If isExtractNow Then
        Me.statusText.Caption = "ÎÄ¼þ¸üÐÂÊ§°Ü¡­¡­"
        Call INIWrite("splash", "update_key", "NULL", App.Path & "\configuration.ini")
        updateFileReady = True
        updateFileDone = True
    ElseIf updateFileDone Then
        Me.statusText.Caption = "Ö÷³ÌÐò¼ÓÔØÊ§°Ü£¡"
        Me.Timer1.Enabled = False
    ElseIf Len(updateKeyRemote) = 0 Then
        Me.statusText.Caption = "ÔÝÊ±ÎÞ·¨È¡µÃÔ¶³Ì¸üÐÂÐÅÏ¢"
        updateFileReady = True
        updateFileDone = True
    End If
End Sub

Private Sub CheckUpdate()
    
End Sub

Private Sub StartExam()
    ' Shell App.Path & "\oExamDesktop.exe"
    Dim cNewDesktop As New cDesktop
    Dim sPath As String
    sPath = App.Path & "\oExamMain.exe"

    cNewDesktop.Create "TEST"
    cNewDesktop.StartProcess sPath
    
    Unload Me
End Sub

