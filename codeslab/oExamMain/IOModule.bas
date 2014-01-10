Attribute VB_Name = "IOModule"
Option Explicit

Dim FSO As FileSystemObject
Dim TS As TextStream
Dim TempS As String
Dim Final As String

Public Function ReadText(fullFilePath As String) As String
On Error Resume Next
    Set FSO = New FileSystemObject
    Set TS = FSO.OpenTextFile(fullFilePath, ForReading, False, TristateTrue)
    
    ReadText = TS.ReadAll
    TS.Close
    
    Set TS = Nothing
    Set FSO = Nothing

End Function


Public Function WriteText(text As String, fullFilePath As String) As String

    Set FSO = New FileSystemObject
    Set TS = FSO.OpenTextFile(fullFilePath, ForWriting, True, TristateTrue)
    
    TS.Write text
    
    TS.Close
    Set TS = Nothing

End Function

