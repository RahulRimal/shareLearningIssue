import 'package:flutter/material.dart';
import 'package:share_learning/data/session_api.dart';
import 'package:share_learning/models/api_status.dart';
// import 'package:share_learning/models/book.dart';
import 'package:share_learning/models/session.dart';

class Session with ChangeNotifier {
  // List<Session> _sessions = [];
  late Session _session;
  bool _loading = false;
  CustomSessionError? _sessionError;

  bool get loading => _loading;

  Session get session => _session;

  CustomSessionError? get sessionError => _sessionError;

  setLoading(bool loading) async {
    _loading = loading;
    notifyListeners();
  }

  setSession(Session session) {
    _session = session;
  }

  setSessionError(CustomSessionError sessionError) {
    _sessionError = sessionError;
  }

  getSession(String userName, String password) async {
    setLoading(true);

    var response = await SessionApi.postSession(userName, password);

    if (response is Success) {
      setSession(response.response as Session);
    }
    if (response is Failure) {
      CustomSessionError sessionError = CustomSessionError(
        code: response.code,
        message: response.errorResponse,
      );
      setSessionError(sessionError as CustomSessionError);
    }
    setLoading(false);
  }
}
