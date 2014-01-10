VERSION 1.0 CLASS
BEGIN
  MultiUse = -1  'True
  Persistable = 0  'NotPersistable
  DataBindingBehavior = 0  'vbNone
  DataSourceBehavior  = 0  'vbNone
  MTSTransactionMode  = 0  'NotAnMTSObject
END
Attribute VB_Name = "cDesktop"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = True
Attribute VB_PredeclaredId = False
Attribute VB_Exposed = False
'VERSION 1.0 CLASS
'BEGIN
'  MultiUse = -1  'True
'End
'Attribute VB_Name = "cDesktop"
'Attribute VB_GlobalNameSpace = False
'Attribute VB_Creatable = True
'Attribute VB_PredeclaredId = False
'Attribute VB_Exposed = False
Option Explicit

Private Declare Sub Sleep Lib "kernel32" (ByVal dwMilliseconds As Long)

Private Type PROCESS_INFORMATION
   hProcess As Long
   hThread As Long
   dwProcessId As Long
   dwThreadId As Long
End Type

Private Type STARTUPINFOW
   cbSize As Long
   lpReserved As Long
   lpDesktop As Long
   lpTitle As Long
   dwX As Long
   dwY As Long
   dwXSize As Long
   dwYSize As Long
   dwXCountChars As Long
   dwYCountChars As Long
   dwFillAttribute As Long
   dwFlags As Long
   wShowWindow As Integer
   cbReserved2 As Integer
   lpReserved2 As Long
   hStdInput As Long
   hStdOutput As Long
   hStdError As Long
End Type

Private Declare Function CreateProcess Lib "kernel32" Alias "CreateProcessW" ( _
      ByVal lpApplicationName As Long, _
      ByVal lpCommandLine As Long, _
      lpProcessAttributes As Any, _
      lpThreadAttributes As Any, _
      ByVal bInheritHandles As Long, _
      ByVal dwCreationFlags As Long, _
      lpEnvironment As Any, _
      ByVal lpCurrentDirectory As Long, _
      lpStartupInfo As STARTUPINFOW, _
      lpProcessInformation As PROCESS_INFORMATION _
   ) As Long
Private Declare Function GetExitCodeProcess Lib "kernel32" ( _
    ByVal hProcess As Long, lpExitCode As Long) As Long
Private Declare Function CloseHandle Lib "kernel32" (ByVal hObject As Long) As Long
Private Declare Function GetThreadDesktop Lib "user32" (ByVal dwThread As Long) As Long
Private Declare Function GetCurrentThreadId Lib "kernel32" () As Long
Private Declare Function OpenInputDesktop Lib "user32" ( _
      ByVal dwFlags As Long, _
      ByVal fInherit As Boolean, _
      ByVal dwDesiredAccess As Long _
   ) As Long
Private Declare Function CreateDesktop Lib "user32" Alias "CreateDesktopW" ( _
      ByVal lpszDesktop As Long, _
      ByVal lpszDevice As Long, _
      pDevmode As Any, _
      ByVal dwFlags As Long, _
      ByVal dwDesiredAccess As Long, _
      lpsa As Any _
   ) As Long
Private Declare Function SetThreadDesktop Lib "user32" (ByVal hDesktop As Long) As Long
Private Declare Function SwitchDesktop Lib "user32" (ByVal hDesktop As Long) As Long
Private Declare Function CloseDesktop Lib "user32" (ByVal hDesktop As Long) As Long
Private Const GENERIC_ALL = &H10000000
Private Const DESKTOP_SWITCHDESKTOP = &H100&
Private Const STILL_ACTIVE = &H103
Private Declare Function WaitForSingleObject Lib "kernel32" (ByVal hHandle As Long, ByVal dwMilliseconds As Long) As Long
Private Const INFINITE As Long = &HFFFFFFFF       '  Infinite timeout

' To Report API errors:
Private Const FORMAT_MESSAGE_ALLOCATE_BUFFER = &H100&
Private Const FORMAT_MESSAGE_ARGUMENT_ARRAY = &H2000&
Private Const FORMAT_MESSAGE_FROM_HMODULE = &H800&
Private Const FORMAT_MESSAGE_FROM_STRING = &H400&
Private Const FORMAT_MESSAGE_FROM_SYSTEM = &H1000&
Private Const FORMAT_MESSAGE_IGNORE_INSERTS = &H200&
Private Const FORMAT_MESSAGE_MAX_WIDTH_MASK = &HFF&
Private Declare Function FormatMessageW Lib "kernel32" ( _
    ByVal dwFlags As Long, lpSource As Any, _
    ByVal dwMessageId As Long, ByVal dwLanguageId As Long, _
    ByVal lpBuffer As Long, ByVal nSize As Long, _
    Arguments As Long) As Long
    
Private Const ERR_BASE As Long = 40670

Private m_sDesktop As String
Private m_hDesktopThreadOld As Long
Private m_hDesktopInputOld As Long
Private m_hDesktop As Long

Public Sub Create(ByVal sDesktopName As String)
Dim lR As Long

   m_hDesktopThreadOld = GetThreadDesktop(GetCurrentThreadId())
   ApiErrorHandler Err.LastDllError, (m_hDesktopThreadOld = 0)
   m_hDesktopInputOld = OpenInputDesktop(0, False, DESKTOP_SWITCHDESKTOP)
   ApiErrorHandler Err.LastDllError, (m_hDesktopInputOld = 0)
   m_hDesktop = CreateDesktop(StrPtr(sDesktopName), ByVal 0&, ByVal 0&, 0, GENERIC_ALL, ByVal 0&)
   ApiErrorHandler Err.LastDllError, (m_hDesktop = 0)
   If Not (m_hDesktop = 0) Then
      lR = SetThreadDesktop(m_hDesktop)
      lR = SwitchDesktop(m_hDesktop)
      m_sDesktop = sDesktopName
   End If
   
End Sub

Public Sub StartProcess(ByVal sPath As String)
Dim tSi As STARTUPINFOW
Dim tPi As PROCESS_INFORMATION
Dim lR As Long
Dim lErr As Long

   ' Must set the desktop to run on in the
   ' STARTUPINFO structure:
   tSi.cbSize = Len(tSi)
   tSi.lpTitle = StrPtr(m_sDesktop)
   tSi.lpDesktop = StrPtr(m_sDesktop)
   
   lR = CreateProcess( _
      StrPtr(sPath), ByVal 0&, ByVal 0&, ByVal 0&, _
      1, 0, ByVal 0&, ByVal 0&, tSi, tPi)
   
   If (lR = 0) Then
   
      lErr = Err.LastDllError
      ' Make sure we get back into the desktop
      ' that contains the application that is
      ' using this class:
      ClearUp
      ' Now show the error
      ApiErrorHandler lErr, True
      
   Else
      
      ' Wait until the process has completed:
      WaitForSingleObject tPi.hProcess, INFINITE
      
      ' Done. Not sure if we need to close these
      ' handles, but it doesn't cause a problem
      CloseHandle tPi.hProcess
      CloseHandle tPi.hThread
           
      ' Once no more processes are running on
      ' the desktop it will automatically
      ' close.
           
   End If

End Sub

Public Sub ClearUp()
   If Not (m_hDesktopInputOld = 0) Then
      SwitchDesktop m_hDesktopInputOld
      m_hDesktopInputOld = 0
   End If
   If Not (m_hDesktopThreadOld = 0) Then
      SetThreadDesktop m_hDesktopThreadOld
      m_hDesktopThreadOld = 0
   End If
   If Not (m_hDesktop = 0) Then
      CloseDesktop m_hDesktop
      m_hDesktop = 0
   End If
End Sub

Private Sub ApiErrorHandler(ByVal lLastDllError As Long, ByVal bFailed As Boolean)
   If bFailed Then
      Err.Raise ERR_BASE + lLastDllError, App.EXEName & ".cDesktop", WinAPIError(lLastDllError)
   End If
End Sub

Private Function WinAPIError(ByVal lLastDllError As Long) As String
Dim sBuff As String
Dim lCount As Long
    
   sBuff = String(256, 0)
   lCount = FormatMessageW( _
      FORMAT_MESSAGE_FROM_SYSTEM Or FORMAT_MESSAGE_IGNORE_INSERTS, _
      0, lLastDllError, 0&, StrPtr(sBuff), Len(sBuff), ByVal 0&)
    If lCount Then
       WinAPIError = Left$(sBuff, lCount)
    End If

End Function

Private Sub Class_Terminate()
   ClearUp
End Sub


